
var $BODY = $('body'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');

// Sidebar
function init_sidebar() {
	// TODO: This is some kind of easy fix, maybe we can improve this
	var setContentHeight = function () {
		// reset height
		$RIGHT_COL.css('min-height', $(window).height());

		var bodyHeight = $BODY.outerHeight(),
			footerHeight = $BODY.hasClass('footer_fixed') ? -10 : $FOOTER.height(),
			leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
			contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

		// normalize content
		contentHeight -= $NAV_MENU.height() + footerHeight +25;

		$RIGHT_COL.css('min-height', contentHeight);
	};

  	$SIDEBAR_MENU.find('a').on('click', function(ev) {
        var $li = $(this).parent();

        if ($li.is('.active')) {
            $li.removeClass('active active-sm');
            $('ul:first', $li).slideUp(function() {
                setContentHeight();
            });
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
                $SIDEBAR_MENU.find('li').removeClass('active active-sm');
                $SIDEBAR_MENU.find('li ul').slideUp();
            }else
            {
				if ( $BODY.is( ".nav-sm" ) )
				{
					if (!$li.parent().is('.child_menu')) {
						$SIDEBAR_MENU.find( "li" ).removeClass( "active active-sm" );
						$SIDEBAR_MENU.find( "li ul" ).slideUp();
					}
				}
			}
            $li.addClass('active');

            $('ul:first', $li).slideDown(function() {
                setContentHeight();
            });
        }
    });

	// toggle small or large menu
	$MENU_TOGGLE.on('click', function() {
		console.log('clicked - menu toggle');

		if ($BODY.hasClass('nav-md')) {
			$SIDEBAR_MENU.find('li.active ul').hide();
			$SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
		} else {
			$SIDEBAR_MENU.find('li.active-sm ul').show();
			$SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
		}

		$BODY.toggleClass('nav-md nav-sm');

		setContentHeight();

		$('.dataTable').each ( function () { $(this).dataTable().fnDraw(); });
	});

	setContentHeight();
};
// /Sidebar End

function init_DataTables() {
	//Categories Table
	var cat_table = $('#datatable-categories').DataTable({
		"order": [[ 9, 'desc' ]],
		"columnDefs": [
		  {
		  	"targets": 'no-sort',
		  	"orderable": false
		  },
		  // {
		  // 	"targets": [0,2,3,4,5,6,7,8,9,10],
		  // 	"searchable": false
		  // }
		]
	});
	cat_table.columns().iterator( 'column', function (ctx, idx) {
		$( cat_table.column(idx).header() ).append('<span class="sort-icon"/>');
	} );
	$('#catNameSearch').on( 'keyup', function () {
	    cat_table
	        .columns( 1 )
	        .search( this.value )
	        .draw();
	} );

	// Location Table
	var loc_table = $('#datatable-locations').DataTable({
		 "processing": true,
        
        "ajax": {
            "url": "/view-location",
            "type": "POST"
        },
        "columns": [
            { "data": "name" },
            { "data": "isCity" },
            { "data": "isArea" },
            { "data": "city" },
            { "data": "sort_order" },
            { "data": "publish" },
            { "data": "update" },
            { "data": "status" }
        ],
		"order": [[ 6, 'desc' ]],
		"columnDefs": [
		  {
		  	"targets": 'no-sort',
		  	"orderable": false
		  },
  		  // {
  		  // 	"targets": [0,2,3,4,5,6,7,8],
  		  // 	"searchable": false
  		  // }
		]
	});
	loc_table.columns().iterator( 'column', function (ctx, idx) {
		$( loc_table.column(idx).header() ).append('<span class="sort-icon"/>');
	} );
	$('#locationNameSearch').on( 'keyup', function () {
	    loc_table
	        .columns( 0 )
	        .search( this.value )
	        .draw();
	} );

	// Approval Table
	var approval_table = $('#datatable-listing_approval').DataTable({
		"order": [[ 4, 'desc' ]],
		"select": {
			"style": 'multi',
			"selector": 'td:first-child'
		},
		// "dom": 'lrtip',
		// "scrollX": true,
		"columnDefs": [
		  {
		  	"targets": 'no-sort',
		  	"orderable": false
		  },
		  {
          	"orderable": false,
          	"className": 'select-checkbox',
          	"targets": 0
		  }
  		  // {
  		  // 	"targets": [1,2,3,4,5,6,7,8],
  		  // 	"searchable": false
  		  // }
		]
	});
	approval_table.columns().iterator( 'column', function (ctx, idx) {
		$( approval_table.column(idx).header() ).append('<span class="sort-icon"/>');
	} );

	approval_table.on("click", "th.select-checkbox", function() {
	    if ($("th.select-checkbox").hasClass("selected")) {
	        approval_table.rows().deselect();
	        $("th.select-checkbox").removeClass("selected");
	    } else {
	        approval_table.rows().select();
	        $("th.select-checkbox").addClass("selected");
	    }
	}).on("select deselect", function() {
	    ("Some selection or deselection going on")
	    if (approval_table.rows({
	            selected: true
	        }).count() !== approval_table.rows().count()) {
	        $("th.select-checkbox").removeClass("selected");
	    } else {
	        $("th.select-checkbox").addClass("selected");
	    }
	});

	$('#listingNameSearch').on( 'keyup', function () {
	    approval_table
	        .columns( 1 )
	        .search( this.value )
	        .draw();
	} );

	var customSrch = $('.customDtSrch').detach();
	$('.dataTables_filter').after(customSrch);

	$('[data-toggle="tooltip"]').tooltip()
};

$('body').on("change", ".status-select", function() {
	var status_option = $(this);
	if (status_option.find('option:selected').val() == 'Published'){
		status_option.parent().find('.notify-user-msg').removeClass('hidden');
	} else {
		status_option.parent().find('.notify-user-msg').addClass('hidden');
	}
});

$('body').on("change", "input[type=radio][name=categoryType]", function() {
    if (this.value == 'parent_cat') {
        $('.select-parent-cat, .select-branch-cat').addClass('hidden')
        $('.parent_cat_icon').removeClass('hidden')
    }
    else if (this.value == 'branch_cat') {
        $('.select-parent-cat').removeClass('hidden')
        $('.select-branch-cat, .parent_cat_icon').addClass('hidden')
    }
    else if (this.value == 'node_cat') {
        $('.select-parent-cat, .select-branch-cat').removeClass('hidden')
        $('.parent_cat_icon').addClass('hidden')
    }
});

$('body').on("change", "input[type=radio][name=locationType]", function() {
    if (this.value == 'city_type') {
        $('.select_city').addClass('hidden')
    }
    else if (this.value == 'area_type') {
        $('.select_city').removeClass('hidden')
        // $('.select-branch-cat, .parent_cat_icon').addClass('hidden')
    }
});

// Multiselect filter on Datatables
function init_Multiselect() {
	$('.multi-dd').multiselect({
		buttonContainer: '<span></span>',
        buttonClass: '',
		templates: {
            button: '<span class="multiselect dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i></span>'
        },
	    onChange: function(element, checked) {

	      var categories = $('.multi-dd option:selected');

	      var selected = [];
	      $(categories).each(function(index, city) {
	        selected.push($(this).val());
	      });

	      var search = selected.join("|");

	      var col = $(this)[0]['$select'].closest('th').data('col')

	      $('#datatable-categories, #datatable-locations, #datatable-listing_approval').DataTable().column(col).search(
	        search, true, false
	      ).draw();

	      // Show/hide first column for Listing Approval table
	      if (selected == "Pending Review"){
	      	$(".select-checkbox").css("display", "table-cell");
	      	$(".bulk-status-update").removeClass('hidden');
	      }else{
	      	$(".select-checkbox").css("display", "none");
	      	$(".bulk-status-update").addClass('hidden');
	      }
	    }
  	});
};
// Multiselect filter on Datatables End

// Email Notifications - Edit Emails
function init_addEmailType(){
	if (typeof autosize !== 'undefined') {
		autosize($('textarea'));
	}

	$('.edit_email_type').on('click', function() {
		$(this).closest('tr').find('textarea').removeClass('no-edit');
		$(this).closest('td').find('.edit-actions').removeClass('hidden');
		$('.edit_email_type').addClass('hidden');
		if (typeof autosize !== 'undefined') {
			var ta = $('textarea');
			autosize.update(ta);
		}
	});
	$('.save_email_type, .cancel_email_type').on('click', function() {
		$(this).closest('tr').find('textarea').addClass('no-edit');
		$(this).closest('td').find('.edit-actions').addClass('hidden');
		$('.edit_email_type').removeClass('hidden');
	});
}
// Email Notifications - Edit Emails End

function init_daterangepicker_submission() {
	// var max = moment();

	if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }

	$('#submissionDate').daterangepicker({
		maxDate: moment()
	});
}

// Category select modal on mobile
$myGroup = $('.cat-dataHolder');
$myGroup.on('show.bs.collapse', '.collapse', function() {
	$myGroup.find('.collapse.in').collapse('hide');
});

$(document).ready(function() {
	init_DataTables();
	init_sidebar();
	init_Multiselect();
	init_addEmailType();
	init_daterangepicker_submission();
});