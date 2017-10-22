<?php

namespace App\Http\Controllers;

use App\Area;
use App\Category;
use App\Listing;
use App\ListingAreasOfOperation;
use App\ListingCategory;
use App\User;
// use App\ListingCategory;

class ListingViewController extends Controller
{
    public function index($city, $listing_slug)
    {
        $listing = Listing::where('slug', $listing_slug)->firstorFail();
        $area    = Area::with('city')->find($listing->locality_id);
        if ($area->city['slug'] != $city) {abort(404);die();}
        if ($listing->status != 1 and $listing->status != 4 and !hasAccess('edit_permission_element_cls', $listing->reference, 'listing')) {abort(404);die();}
        $pagedata                      = $this->getListingData($listing);
        $pagedata['browse_categories'] = $this->getPopularParentCategories();
        // dd($pagedata);
        $similar = $this->similarBusinesses($listing);
        // dd($similar);
        return view('single-view.listing')->with('data', $pagedata)->with('similar', $similar);
    }

    private function getListingData($listing)
    {
        $pagedata              = array();
        $area                  = Area::with('city')->find($listing->locality_id);
        $pagedata['pagetitle'] = getSingleListingTitle($listing);
        $pagedata['premium']   = $listing->isPremium();
        $pagedata['verified']  = ($listing->owner_id == null)? false:true;
        $pagedata['city']      = array('name' => $area->city['name'], 'url' => '', 'alt' => 'All business listings in ('.$area->city['name'].')', 'area' => $area->name);
        $pagedata['title']     = ['name' => $listing->title, 'url' => env('APP_URL') . '/' . $area->city['slug'] . '/' . $listing->slug, 'alt' => ''];
        $pagedata['update']    = $listing->updated_at->format('jS F');
        $pagedata['updates']   = $listing->updates()->orderBy('updated_at', 'desc')->first();
        // dd($pagedata['updates']->getImages());
        if ($listing->status == 1) {
            $pagedata['publish_date'] = $listing->published_on->format('F j, Y');
            $pagedata['rating']       = '50';
            $pagedata['views']        = $listing->views_count;
            // $pagedata['verified']     = ($listing->verified == 1) ? true : false;
        }

        $pagedata['type']           = config('tempconfig.listing-type')[$listing->type];
        $pagedata['reference']      = $listing->reference;
        $pagedata['operationAreas'] = ListingAreasOfOperation::city($listing->id);
        if (count($pagedata['operationAreas']) == 0) {
            unset($pagedata['operationAreas']);
        }

        $pagedata['contact'] = ['email' => [], 'mobile' => [], 'landline' => [], 'requests' => $listing->contact_request_count];
        if ($listing->show_primary_email) {
            $pagedata['contact']['email'][] = ['value' => User::find($listing->owner_id)->getPrimaryEmail(), 'verified' => true, 'type' => 'email'];
        }

        $contacts = $listing->contacts()->get();
        foreach ($contacts as $contact) {
            if ($contact->type == 'email') {
                if ($contact->is_visible == 1) {
                    $pagedata['contact']['email'][] = ['value' => '+' . $contact->country_code . $contact->value, 'verified' => ($contact->is_verified == 1) ? true : false, 'type' => 'email'];
                }

            }
            if ($contact->type == 'mobile') {
                if ($contact->is_visible == 1) {
                    $pagedata['contact']['mobile'][] = ['value' => '+' . $contact->country_code . $contact->value, 'verified' => ($contact->is_verified == 1) ? true : false, 'type' => 'mobile'];
                }

            }
            if ($contact->type == 'landline') {
                if ($contact->is_visible == 1) {
                    $pagedata['contact']['landline'][] = ['value' => '+' . $contact->country_code . $contact->value, 'verified' => ($contact->is_verified == 1) ? true : false, 'type' => 'landline'];
                }

            }

        }
        if (count($pagedata['contact']['landline']) == 0) {
            unset($pagedata['contact']['landline']);
        }

        if (count($pagedata['contact']['mobile']) == 0) {
            unset($pagedata['contact']['mobile']);
        }

        if (count($pagedata['contact']['email']) == 0) {
            unset($pagedata['contact']['email']);
        }

        $pagedata['categories'] = ListingCategory::getCategories($listing->id);
        if (count($pagedata['categories']) != 0) {
            $pagedata['cores'] = [];
            foreach ($pagedata['categories'] as $category) {
                foreach ($category['nodes'] as $node) {
                    if ($node['core'] == "1") {
                        $pagedata['cores'][] = $node;
                    }

                }
            }
            $pagedata['brands'] = $listing->tagNames('brands');
            if (count($pagedata['brands']) == 0) {
                unset($pagedata['brands']);
            }

        } else {
            unset($pagedata['categories']);
        }
        $pagedata['highlights'] = json_decode($listing->highlights);
        if ($pagedata['highlights'] == null) {
            unset($pagedata['highlights']);
        }

        $pagedata['description'] = $listing->description;
        if ($pagedata['description'] == null) {
            unset($pagedata['description']);
        }

        if ($listing->other_details != null) {
            $other_details = json_decode($listing->other_details);
            if (isset($other_details->established)) {
                $pagedata['established'] = $other_details->established;
            }

            if (isset($other_details->website)) {
                $pagedata['website'] = $other_details->website;
            }

        }
        if ($listing->show_hours_of_operation != null) {
            $pagedata['showHours'] = $listing->show_hours_of_operation;
            $pagedata['hours']     = $listing->getHoursofOperation();
            $pagedata['today']     = $listing->today();
        }
        $pagedata['address'] = $listing->display_address;
        if ($pagedata['address'] == null) {
            unset($pagedata['address']);
        }

        $pagedata['payments'] = $listing->getPayments();
        if ($pagedata['payments'] == null) {
            unset($pagedata['payments']);
        }

        $pagedata['location'] = [
            'lat' => $listing->latitude,
            'lng' => $listing->longitude,
        ];
        if ($pagedata['location']['lat'] == null or $pagedata['location']['lng'] == null) {
            unset($pagedata['location']);
        }

        $pagedata['images'] = [];
        $images             = $listing->getImages();
        if (count($images) != 0) {
            $list_photos = json_decode($listing->photos);
            if ($list_photos != null) {
                $order = explode(',', $list_photos->order);
            } else {
                $order = [];
            }

            foreach ($order as $img) {
                $pagedata['images'][] = ['full' => $images[$img][config('tempconfig.listing-photo-full')], 'thumb' => $images[$img][config('tempconfig.listing-photo-thumb')]];
            }
        } else {
            unset($pagedata['images']);
        }
        $pagedata['files'] = $listing->getFiles();
        if (count($pagedata['files']) != 0) {
            foreach ($pagedata['files'] as &$file) {
                if ($file['name'] == "") {
                    $file['name'] = basename($file['url']);
                }

            }
        } else {
            unset($pagedata['files']);
        }

        $pagedata['status'] = [];
        if ($listing->status == "3") {
            $pagedata['status']['text']   = "The current status of your listing is ";
            $pagedata['status']['status'] = 'Draft <i class="fa fa-info-circle text-color m-l-5 draft-status" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i>';
            $pagedata['status']['id']     = '3';
            if ($listing->isReviewable()) {
                $pagedata['status']['change'] = '<form action="' . action('ListingController@submitForReview') . '" method="post"><input type="hidden" name="listing_id" value="' . $listing->reference . '"><button type="submit" class="btn fnb-btn text-primary border-btn no-border">Submit for Review</button></form>';
                $pagedata['status']['next'] = 'Submit for Review';
            } else {
                $pagedata['status']['change'] = '';
            }
        } elseif ($listing->status == "2") {
            $pagedata['status']['text']   = "Your listing is submitted for approval";
            $pagedata['status']['status'] = '<i class="fa fa-clock-o text-primary" aria-hidden="true"></i>Pending Approval ';
            $pagedata['status']['id']     = '2';
            $pagedata['status']['change'] = '';
        } elseif ($listing->status == "1") {
            $pagedata['status']['text']   = "The current status of your listing is ";
            $pagedata['status']['status'] = 'Published';
            $pagedata['status']['id']     = '1';
            $pagedata['status']['change'] = '<form action="' . action('ListingController@archive') . '" method="post"><input type="hidden" name="listing_id" value="' . $listing->reference . '"><button class="btn fnb-btn text-primary border-btn no-border" type="submit">Archive</button></form>';
            $pagedata['status']['next'] = 'Archive';
        } elseif ($listing->status == "4") {
            $pagedata['status']['text']   = "The current status of your listing is ";
            $pagedata['status']['status'] = 'Archived';
            $pagedata['status']['id']     = '4';
            $pagedata['status']['change'] = '<form action="' . action('ListingController@publish') . '" method="post"><input type="hidden" name="listing_id" value="' . $listing->reference . '"><button class="btn fnb-btn text-primary border-btn no-border" type="submit">Publish</button></form>';
            $pagedata['status']['next'] = 'Publish';
        } elseif ($listing->status == "5") {
            $pagedata['status']['text']   = "The current status of your listing is ";
            $pagedata['status']['status'] = 'Rejected';
            $pagedata['status']['id']     = '5';
            $pagedata['status']['change'] = '<form action="' . action('ListingController@submitForReview') . '" method="post"><input type="hidden" name="listing_id" value="' . $listing->reference . '"><button class="btn fnb-btn text-primary border-btn no-border" type="submit">Submit for Review</button></form>';
            $pagedata['status']['next'] = 'Submit for Review';
        }
        if (isset($pagedata['highlights']) or isset($pagedata['description']) or isset($pagedata['established']) or isset($pagedata['website']) or isset($pagedata['hours']) or isset($pagedata['address']) or isset($pagedata['location'])) {
            $pagedata['overview'] = true;
        }

        return $pagedata;
    }

    private function similarBusinesses($listing)
    {

        $similar_id = [$listing->id];
        $categories = ListingCategory::where('listing_id', $listing->id)->where('core', 1)->pluck('category_id')->toArray();
        $simCore    = array_unique(ListingCategory::whereIn('category_id', $categories)->where('core',1)->whereNotIn('listing_id', $similar_id)->pluck('listing_id')->toArray());

        //rule : At least 1 core category matching + type + locality
        $similar = Listing::whereNotIn('id', $similar_id)->whereIn('id', $simCore)->where('status', 1)->where('type', $listing->type)->where('locality_id', $listing->locality_id)->orderBy('premium')->orderBy('updated_at')->take(2)->get();
        $url     = 'url1';
        foreach ($similar as $sim) {
            $similar_id[] = $sim->id;

        }

        if (count($similar_id) < 3) {
            //rule : At least 1 core category matching + type
            $url     = 'url2';
            $similar = Listing::whereNotIn('id', $similar_id)->whereIn('id', $simCore)->where('status', 1)->where('type', $listing->type)->orderBy('premium')->orderBy('updated_at')->take(2)->get();
            foreach ($similar as $sim) {
                $similar_id[] = $sim->id;

            }
            if (count($similar_id) < 3) {
                //rule : At least 1 core category matching + location
                $url     = 'url3';
                $similar = Listing::whereNotIn('id', $similar_id)->whereIn('id', $simCore)->where('status', 1)->orderBy('premium')->orderBy('updated_at')->take(2)->get();
                foreach ($similar as $sim) {
                    $similar_id[] = $sim->id;

                }
                if (count($similar_id) < 3) {
                    //rule : At least 1 core category matching
                    $url     = 'url4';
                    $similar = Listing::whereNotIn('id', $similar_id)->whereIn('id', $simCore)->where('status', 1)->where('locality_id', $listing->locality_id)->orderBy('premium')->orderBy('updated_at')->take(2)->get();
                    foreach ($similar as $sim) {
                        $similar_id[] = $sim->id;

                    }
                    // if(count($similar_id)<3){
                    //     //rule : no rule
                    //     $url='url4';
                    //     $similar = Listing::whereNotIn('id',$similar_id)->where('status',1)->orderBy('updated_at')->take(2)->get();
                    //     foreach ($similar as $sim) {
                    //         $similar_id[] = $sim->id;

                    //     }
                    // }
                }
            }
        }
        unset($similar_id[0]);
        $similar = [];
        foreach ($similar_id as $id) {
            $similar[] = $this->getListingData(Listing::find($id));
        }
        $similar['url'] = $url;
        return $similar;

    }

    private function getPopularParentCategories()
    {
        $parents    = Category::where('type', 'listing')->where('level', '1')->where('status', 1)->orderBy('order')->orderBy('name')->take(config('tempconfig.single-view-category-number'))->get();
        $categories = [];
        foreach ($parents as $category) {
            $categories[$category->id] = [
                'id'    => $category->id,
                'name'  => $category->name,
                'slug'  => $category->slug,
                'image' => $category->icon_url,
                'count' => count($category->getAssociatedListings()['data']['listings']),
            ];
        }
        return $categories;
    }
}
