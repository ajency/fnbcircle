<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\Common;
use App\Http\Controllers\ListingController;
use App\Listing;
use App\ListingCategory;
use App\ListingCommunication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Console\Output\ConsoleOutput;

class AdminModerationController extends Controller
{
    public function __construct()
    {
        Common::authenticate('dashboard', $this);
    }
    public function listingApproval(Request $request)
    {
        $parent_categ = Category::whereNull('parent_id')->orderBy('order')->orderBy('name')->get();
        $cities       = City::where('status', '1')->get();
        return view('admin-dashboard.listing_approval')->with('parents', $parent_categ)->with('cities', $cities);
    }

    public function displayListingsDum(Request $request)
    {
        // print_r($request->all());
        // dd($request->all());
        $filters = $request->filters;
        switch ($request->order['0']['column']) {
            case '1':
                $sort_by = 'title';
                $order   = $request->order['0']['dir'];
                break;
            case '4':
                $sort_by = "submission_date";
                $order   = $request->order['0']['dir'];
                break;
            case '5':
                $sort_by = "updated_at";
                $order   = $request->order['0']['dir'];
                break;
            default:
                $sort_by = "";
                $order   = "";

        }
        // $filters  = array();
        $response = $this->displayListings($request->length, $request->start, $sort_by, $order, $filters);

        $status = ['3' => 'Draft', '2' => 'Pending Review', '1' => 'Published', '4' => 'Archived', '5' => 'Rejected'];

        foreach ($response['data'] as &$listing) {
            $listing['status_ref'] = $listing['status'];
            $listing['status']     = $status[$listing['status']] . '<a href="#updateStatusModal" data-target="#updateStatusModal" data-toggle="modal"><i class="fa fa-pencil"></i></a>';
            $listing['name']       = '<a href="/listing/' . $listing['reference'] . '/edit">' . $listing['name'] . '</a>';
            $listing['#']          = "";
            // if (count($filters['status'])==1) $listing['#'] = '<td class=" select-checkbox" style="display: table-cell;"></td>';
            // dd($listing['categories']);
            $i    = 0;
            $temp = '';
            foreach ($listing['categories'] as $key => $value) {
                if ($i != 0) {
                    $temp .= "<hr>";
                } else {
                    $temp .= "";
                }

                $temp .= $value['parent'] . ' > ' . $value['branch'] . ' > ';
                $j = 0;
                foreach ($value['nodes'] as $node) {
                    if ($j != 0) {
                        $temp .= ', ';
                    }

                    $temp .= $node['name'];
                    $j++;
                }
                $i++;
            }
            $listing['categories'] = $temp;
            // dd($listing['categories']);
        }

        return response()->json($response);
    }
    public function displayListings($display_limit, $start, $sort, $order, $filters)
    {
        $listings = Listing::where(function ($sql) use ($filters) {
            $i = 0;
            // dd($filters);
            if (isset($filters['status'])) {
                foreach ($filters['status'] as $status) {
                    if ($i == 0) {
                        $sql->where('status', $status);
                    } else { $sql->orWhere('status', $status);}
                    $i++;
                }
            }
        });
        $end = new Carbon($filters['submission_date']['end']);
        if ($filters['submission_date']['start'] != "") {
            $listings->where('submission_date', '>', $filters['submission_date']['start'])->where('submission_date', '<', $end->addDay()->toDateTimeString());
        }
        $filtered = $listings->count();
        $listings = $listings->skip($start)->take($display_limit);
        $listings = ($sort == "") ? $listings : $listings->orderBy($sort, $order);
        $output   = new ConsoleOutput;
        // $output->writeln($listings->toSql());
        // $output->writeln($filters['submission_date']['start']);
        // $output->writeln($filters['submission_date']['end']);

        $listings = $listings->get();
        // $filtered = count($listings);
        $output->writeln(json_encode($listings));
        $response = array();

        foreach ($listings as $listing) {
            $output->writeln($listing->submission);
            $sub                                       = ($listing->submission_date != null) ? $listing->submission_date->toDateTimeString() : '';
            $response[$listing->id]                    = array('id' => $listing->id, 'name' => $listing->title, 'submission_date' => $sub, 'updated_on' => $listing->updated_at->toDateTimeString());
            $response[$listing->id]['status']          = $listing->status;
            $response[$listing->id]['reference']       = $listing->reference;
            $response[$listing->id]['last_updated_by'] = $listing->lastUpdatedBy['name'];
            if (isset($filters['city']) and !in_array($listing->location['city_id'], $filters['city'])) {
                unset($response[$listing->id]);
                $filtered--;
                continue;
            }
            $city = City::find($listing->location['city_id']);
            //write the logic to filter the city and remove them from response. count the number of removed entries and subtract them from
            $response[$listing->id]['city'] = $city['name'];
            // $output->writeln(json_encode($listing->lastUpdatedBy));
            if (isset($filters['category_nodes'])) {
                $categories = ListingCategory::where('listing_id', $listing->id)->get();
                $check      = false;
                foreach ($categories as $category) {
                    if (in_array($category->category_id, $filters['category_nodes'])) {
                        $check = true;
                    }
                }
                if (!$check) {
                    unset($response[$listing->id]);
                    $filtered--;
                    continue;
                }
            }
            $dup                                  = $this->getDuplicateCount($listing->id, $listing->title);
            $response[$listing->id]['duplicates'] = $dup['phone'] . ',' . $dup['email'] . ',' . $dup['title'];
            $response[$listing->id]['premium']    = 'No';
            $response[$listing->id]['categories'] = ListingCategory::getCategories($listing->id);
        }
        $response1 = array();
        foreach ($response as $resp) {
            $response1[] = $resp;
        }
        $all = Listing::count();

        return array('draw' => "1", 'sEcho' => 0, "recordsTotal" => $all, "recordsFiltered" => $filtered, 'data' => $response1);

    }

    private function getDuplicateCount($id, $name)
    {
        $contacts = ListingCommunication::where('listing_id', $id)->get();
        $request  = new Request;
        $title    = $name;
        $req      = array();
        $req[]    = array('value' => Listing::find($id)->owner->email);
        foreach ($contacts as $contact) {
            $req[] = array('value' => $contact->value);
        }
        $contacts = json_encode($req);
        // if ($id=='27') dd($contacts);
        $request->merge(array('title' => $title, 'contacts' => $contacts));
        $lc   = new ListingController;
        $dup  = $lc->findDuplicates($request);
        $data = json_decode(json_encode($dup), true)['original']['matches'];

        return array('title' => count($data['title']), 'email' => count($data['email']), 'phone' => count($data['phones']));
    }

    public function setStatus(Request $request)
    {
        $this->validate($request, [
            'change_request' => 'required|json',
            'sendmail'       => 'nullable|boolean',
        ]);
        $response       = array('status' => "", 'message' => '', 'data' => array('success' => array(), 'error' => array()));
        $change_request = json_decode($request->change_request);
        foreach ($change_request as $change) {
            $listing = Listing::find($change->id);
            if ($listing->status == Listing::DRAFT) {
                if ($change->status == (string) Listing::REVIEW) {
                    if ($listing->isReviewable()) {
                        $listing->status = Listing::REVIEW;
                        $listing->save();
                        $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.');
                    } else {
                        $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing doesnt meet Reviewable criteria');
                        $response['status']          = 'Error';
                    }
                } else {
                    $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Draft listing can only be changed to pending review');
                    $response['status']          = 'Error';
                }
            } else if ($listing->status == Listing::REVIEW) {
                if ($change->status == (string) Listing::PUBLISHED) {
                    $listing->status = Listing::PUBLISHED;
                    $listing->save();
                    $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.');
                    if ($request->sendmail == "1") {
                        //sendmail('published',$listing_id);
                    }
                } else if ($change->status == (string) Listing::REJECTED) {
                    $listing->status = Listing::REJECTED;
                    $listing->save();
                    $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.');
                    if ($request->sendmail == "1") {
                        //sendmail('rejected',$listing_id);
                    }
                } else {
                    $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Pending review listing can only be changed to published or rejected');
                    $response['status']          = 'Error';
                }
            } else if ($listing->status == Listing::PUBLISHED) {
                if ($change->status == (string) Listing::ARCHIVED) {
                    $listing->status = Listing::ARCHIVED;
                    $listing->save();
                    $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.');
                } else {
                    $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Published listing can only be changed to Archived');
                    $response['status']          = 'Error';
                }

            } else if ($listing->status == Listing::REJECTED) {
                if ($change->status == (string) Listing::ARCHIVED) {
                    $listing->status = Listing::ARCHIVED;
                    $listing->save();
                    $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.');
                } else if ($change->status == (string) Listing::REVIEW) {
                    if ($listing->isReviewable()) {
                        $listing->status = Listing::REVIEW;
                        $listing->save();
                        $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.');
                    } else {
                        $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing doesnt meet Reviewable criteria');
                        $response['status']          = 'Error';
                    }
                } else {
                    $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Rejected listing can only be changed to Archived/Pending Review');
                    $response['status']          = 'Error';
                }

            } else if ($listing->status == Listing::ARCHIVED) {
                if ($change->status == (string) Listing::REVIEW) {
                    if ($listing->isReviewable()) {
                        $listing->status = Listing::REVIEW;
                        $listing->save();
                        $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.');
                    } else {
                        $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing doesnt meet Reviewable criteria');
                        $response['status']          = 'Error';
                    }
                } else if ($change->status == (string) Listing::PUBLISHED) {
                    $listing->status = Listing::PUBLISHED;
                    $listing->save();
                    $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.');
                } else {
                    $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Archieved listing can only be changed to Published/Pending Review');
                    $response['status']          = 'Error';
                }
            }

        }

        return response()->json($response);

    }
}
