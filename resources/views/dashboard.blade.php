@extends('layouts.app-master', ['activePage' => 'dashboard', 'activeSub' => '', 'titlePage' => __('Dashboard')])

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<style>
    path {
    stroke: white;
    fill:paleturquoise !important;

    transition: fill .4s ease;
    transform-origin: center center;
}

path:hover {
    fill: orange !important;
    cursor: pointer;
    transform: scale(1.005, 1.005);
}

/* #map-container {
    display: flex;
    justify-content: center;
    align-items: center;
} */

#us-map {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

#details-box {
    box-shadow: 0px 7px 40px rgba(0, 0, 0, 0.7);
    opacity: 0%;
    padding: 1rem;
    border-radius: 8px;
    font-size: 24px;
    position: fixed;
    color: white;
    font-family: "Poppins";
    background-color: black;
    width: fit-content;
    transform: translateX(-50%);
    transition: opacity .4s ease;
    z-index: 1;
}

.country-bg{
    background-color: #2a2929 !important;
}

.card-bg{
 background-color: #343434;
    color: white;
}

.card-h4 {
  color: white !important;
}

.chart-bg{
    background-color: #4d4c4c;
}



  </style>
    <div class="bg-light p-4 rounded">
         
        <div class="container-fluid">
            <div class="row" style="height: 500px; margin-bottom: 10rem; ">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons"></i>
                            </div>
                            <h4 class="card-title">Sales By US States</h4>
                        </div>
                        <div class="card-body" style="height: 500px">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive table-sales" style="    overflow-y: scroll;height: 500px;">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                    $states = DB::table('states')
                                                    ->select('*')
                                                    ->get();
                                                     $dailytotalorders = DB::table('orders')
                                                    ->select('id')
                                                    ->where('created_at','like',date('Y-m-d').'%')
                                                    ->count('id');
                                                     $dailydeliverdorders = DB::table('orders')
                                                    ->select('id')
                                                    ->where('created_at','like',date('Y-m-d').'%')
                                                    ->where('status','=',"delivered")
                                                    ->count('id');
                                                    $totalorders = DB::table('orders')
                                                    ->select('id')
                                                    ->count('id');
                                                     $paidrevenue = DB::table('orders')
                                                    ->select('id')
                                                    ->where('status','=',"delivered")
                                                    ->sum('total_amount');
                                                    $UNpaidrevenue = DB::table('orders')
                                                    ->select('id')
                                                    ->where('status','!=',"delivered")
                                                    ->sum('total_amount');
                                                     $webvisit = DB::table('webvisit')
                                                    ->select('webvisit_id')
                                                    ->count('webvisit_id');
                                                ?>
                                                @foreach($states as $val)
                                                <?php
                                                 $statesorder = DB::table('orders')
                                                ->where('states_id','=' ,$val->states_id)
                                                ->select('id')
                                                ->count('id');
                                                ?>
                                                <tr>
                                                    <td>{{$val->states_name}}</td>
                                                    <td>{{$statesorder}}</td>
                                                </tr>
                                                @endforeach
                                           </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6 ml-auto mr-auto">
                                    <div style="height: 300px;">
                                        @include('usmap')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-rose" data-header-animation="true">
                            <div class="ct-chart" id="websiteViewsChart"></div>
                        </div>
                        <div class="card-body">
                        <!--     <div class="card-actions">
                                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                    <i class="material-icons">build</i> Fix Header!
                                </button>
                                <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                                    <i class="material-icons">refresh</i>
                                </button>
                                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                                    <i class="material-icons">edit</i>
                                </button>
                            </div> -->
                            <h4 class="card-title">Website Views</h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!-- <i class="material-icons">access_time</i> campaign sent 2 days ago -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-success" data-header-animation="true">
                            <div class="ct-chart" id="dailySalesChart"></div>
                        </div>
                        <div class="card-body">
                            <div class="card-actions">
                               <!--  <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                    <i class="material-icons">build</i> Fix Header!
                                </button>
                                <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                                    <i class="material-icons">refresh</i>
                                </button>
                                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                                    <i class="material-icons">edit</i>
                                </button> -->
                            </div>
                            <h4 class="card-title">Daily Sales</h4>
                            <p class="card-category">
                                <!-- <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p> -->
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!-- <i class="material-icons">access_time</i> updated 4 minutes ago -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-info" data-header-animation="true">
                            <div class="ct-chart" id="completedTasksChart"></div>
                        </div>
                        <div class="card-body">
                            <div class="card-actions">
                              <!--   <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                    <i class="material-icons">build</i> Fix Header!
                                </button>
                                <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                                    <i class="material-icons">refresh</i>
                                </button>
                                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                                    <i class="material-icons">edit</i>
                                </button> -->
                            </div>
                            <h4 class="card-title">Daily Delivered Orders</h4>
                            <!-- <p class="card-category">Last Campaign Performance</p> -->
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!-- <i class="material-icons">access_time</i> campaign sent 2 days ago -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">equalizer</i>
                            </div>
                            <p class="card-category">Website Visits</p>
                            <h3 class="card-title">{{$webvisit}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!-- <i class="material-icons">local_offer</i> Tracked from Google Analytics -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">weekend</i>
                            </div>
                            <p class="card-category">Total Order</p>
                            <h3 class="card-title">{{$totalorders}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!-- <i class="material-icons text-danger">warning</i> -->
                                <!-- <a href="#pablo">Get More Space...</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">store</i>
                            </div>
                            <p class="card-category">Paid Revenue</p>
                            <h3 class="card-title">${{$paidrevenue}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!-- <i class="material-icons">date_range</i> Last 24 Hours -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">store</i>
                            </div>
                            <p class="card-category">Unpaid Revenue</p>
                            <h3 class="card-title">${{$UNpaidrevenue}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!-- <i class="material-icons">update</i> Just Updated -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <!--  <h3>Manage Listings</h3>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-product">
                        <div class="card-header card-header-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="../assets/img/card-2.jpg">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-actions text-center">
                                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                    <i class="material-icons">build</i> Fix Header!
                                </button>
                                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                </button>
                                <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                    <i class="material-icons">edit</i>
                                </button>
                                <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                            <h4 class="card-title">
                                <a href="#pablo">Cozy 5 Stars Apartment</a>
                            </h4>
                            <div class="card-description">
                                The place is close to Barceloneta Beach and bus stop just 2 min by walk and near to "Naviglio" where you can enjoy the main night life in Barcelona.
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="price">
                                <h4>$899/night</h4>
                            </div>
                            <div class="stats">
                                <p class="card-category"><i class="material-icons">place</i> Barcelona, Spain</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-product">
                        <div class="card-header card-header-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="../assets/img/card-3.jpg">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-actions text-center">
                                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                    <i class="material-icons">build</i> Fix Header!
                                </button>
                                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                </button>
                                <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                    <i class="material-icons">edit</i>
                                </button>
                                <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                            <h4 class="card-title">
                                <a href="#pablo">Office Studio</a>
                            </h4>
                            <div class="card-description">
                                The place is close to Metro Station and bus stop just 2 min by walk and near to "Naviglio" where you can enjoy the night life in London, UK.
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="price">
                                <h4>$1.119/night</h4>
                            </div>
                            <div class="stats">
                                <p class="card-category"><i class="material-icons">place</i> London, UK</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-product">
                        <div class="card-header card-header-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="../assets/img/card-1.jpg">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-actions text-center">
                                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                    <i class="material-icons">build</i> Fix Header!
                                </button>
                                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                </button>
                                <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                    <i class="material-icons">edit</i>
                                </button>
                                <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                            <h4 class="card-title">
                                <a href="#pablo">Beautiful Castle</a>
                            </h4>
                            <div class="card-description">
                                The place is close to Metro Station and bus stop just 2 min by walk and near to "Naviglio" where you can enjoy the main night life in Milan.
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="price">
                                <h4>$459/night</h4>
                            </div>
                            <div class="stats">
                                <p class="card-category"><i class="material-icons">place</i> Milan, Italy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
@endsection
@section('scripts')

    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            md.initDashboardPageCharts();

            md.initVectorMap();

        });
        /*!

 =========================================================
 * Material Dashboard PRO - v2.1.2
 =========================================================

 * Product Page: https://www.creative-tim.com/product/material-dashboard-pro
 * Copyright 2020 Creative Tim (http://www.creative-tim.com)

 * Designed by www.invisionapp.com Coded by www.creative-tim.com

 =========================================================

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

 */

(function() {
  isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;

  if (isWindows) {
    // if we are on windows OS we activate the perfectScrollbar function
    if ($(".sidebar").length != 0) {
      var ps = new PerfectScrollbar('.sidebar');
    }
    if ($(".sidebar-wrapper").length != 0) {
      var ps1 = new PerfectScrollbar('.sidebar-wrapper');
    }
    if ($(".main-panel").length != 0) {
      var ps2 = new PerfectScrollbar('.main-panel');
    }
    if ($(".main").length != 0) {
      var ps3 = new PerfectScrollbar('main');
    }
    $('html').addClass('perfect-scrollbar-on');
  } else {
    $('html').addClass('perfect-scrollbar-off');
  }
})();


var breakCards = true;

var searchVisible = 0;
var transparent = true;

var transparentDemo = true;
var fixedTop = false;

var mobile_menu_visible = 0,
  mobile_menu_initialized = false,
  toggle_initialized = false,
  bootstrap_nav_initialized = false;

var seq = 0,
  delays = 80,
  durations = 500;
var seq2 = 0,
  delays2 = 80,
  durations2 = 500;

$(document).ready(function() {
  $sidebar = $('.sidebar');
  window_width = $(window).width();

  $('body').bootstrapMaterialDesign({
    autofill: false
  });

  md.initSidebarsCheck();

  window_width = $(window).width();

  // check if there is an image set for the sidebar's background
  md.checkSidebarImage();

  md.initMinimizeSidebar();

  // Multilevel Dropdown menu

  $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
    var $el = $(this);
    var $parent = $(this).offsetParent(".dropdown-menu");
    if (!$(this).next().hasClass('show')) {
      $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
    }
    var $subMenu = $(this).next(".dropdown-menu");
    $subMenu.toggleClass('show');

    $(this).closest("a").toggleClass('open');

    $(this).parents('a.dropdown-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
      $('.dropdown-menu .show').removeClass("show");
    });

    if (!$parent.parent().hasClass('navbar-nav')) {
      $el.next().css({
        "top": $el[0].offsetTop,
        "left": $parent.outerWidth() - 4
      });
    }

    return false;
  });


  //   Activate bootstrap-select
  if ($(".selectpicker").length != 0) {
    $(".selectpicker").selectpicker();
  }

  //  Activate the tooltips
  $('[rel="tooltip"]').tooltip();

  // Activate Popovers
  $('[data-toggle="popover"]').popover();

  //Activate tags
  // we style the badges with our colors
  var tagClass = $('.tagsinput').data('color');

  if ($(".tagsinput").length != 0) {
    $('.tagsinput').tagsinput();
  }

  $('.bootstrap-tagsinput').addClass('' + tagClass + '-badge');

  //    Activate bootstrap-select
  $(".select").dropdown({
    "dropdownClass": "dropdown-menu",
    "optionClass": ""
  });

  $('.form-control').on("focus", function() {
    $(this).parent('.input-group').addClass("input-group-focus");
  }).on("blur", function() {
    $(this).parent(".input-group").removeClass("input-group-focus");
  });


  if (breakCards == true) {
    // We break the cards headers if there is too much stress on them :-)
    $('[data-header-animation="true"]').each(function() {
      var $fix_button = $(this)
      var $card = $(this).parent('.card');

      $card.find('.fix-broken-card').click(function() {
        console.log(this);
        var $header = $(this).parent().parent().siblings('.card-header, .card-header-image');

        $header.removeClass('hinge').addClass('fadeInDown');

        $card.attr('data-count', 0);

        setTimeout(function() {
          $header.removeClass('fadeInDown animate');
        }, 480);
      });

      $card.mouseenter(function() {
        var $this = $(this);
        hover_count = parseInt($this.attr('data-count'), 10) + 1 || 0;
        $this.attr("data-count", hover_count);

        if (hover_count >= 20) {
          $(this).children('.card-header, .card-header-image').addClass('hinge animated');
        }
      });
    });
  }

  // remove class has-error for checkbox validation
  $('input[type="checkbox"][required="true"], input[type="radio"][required="true"]').on('click', function() {
    if ($(this).hasClass('error')) {
      $(this).closest('div').removeClass('has-error');
    }
  });

});

$(document).on('click', '.navbar-toggler', function() {
  $toggle = $(this);

  if (mobile_menu_visible == 1) {
    $('html').removeClass('nav-open');

    $('.close-layer').remove();
    setTimeout(function() {
      $toggle.removeClass('toggled');
    }, 400);

    mobile_menu_visible = 0;
  } else {
    setTimeout(function() {
      $toggle.addClass('toggled');
    }, 430);

    var $layer = $('<div class="close-layer"></div>');

    if ($('body').find('.main-panel').length != 0) {
      $layer.appendTo(".main-panel");

    } else if (($('body').hasClass('off-canvas-sidebar'))) {
      $layer.appendTo(".wrapper-full-page");
    }

    setTimeout(function() {
      $layer.addClass('visible');
    }, 100);

    $layer.click(function() {
      $('html').removeClass('nav-open');
      mobile_menu_visible = 0;

      $layer.removeClass('visible');

      setTimeout(function() {
        $layer.remove();
        $toggle.removeClass('toggled');

      }, 400);
    });

    $('html').addClass('nav-open');
    mobile_menu_visible = 1;

  }

});

// activate collapse right menu when the windows is resized
$(window).resize(function() {
  md.initSidebarsCheck();

  // reset the seq for charts drawing animations
  seq = seq2 = 0;

  setTimeout(function() {
    md.initDashboardPageCharts();
  }, 500);
});

md = {
  misc: {
    navbar_menu_visible: 0,
    active_collapse: true,
    disabled_collapse_init: 0,
  },

  checkSidebarImage: function() {
    $sidebar = $('.sidebar');
    image_src = $sidebar.data('image');

    if (image_src !== undefined) {
      sidebar_container = '<div class="sidebar-background" style="background-image: url(' + image_src + ') "/>';
      $sidebar.append(sidebar_container);
    }
  },

  showNotification: function(from, align, msg, color) {
    type = ['', 'info', 'danger', 'success', 'warning', 'rose', 'primary'];

    $.notify({
      icon: "add_alert",
      message: msg

    }, {
      type: color,
      timer: 3000,
      placement: {
        from: from,
        align: align
      }
    });
  },

  initDocumentationCharts: function() {
    if ($('#dailySalesChart').length != 0 && $('#websiteViewsChart').length != 0) {
      /* ----------==========     Daily Sales Chart initialization For Documentation    ==========---------- */

      dataDailySalesChart = {
        labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
        series: [
          [12, 17, 7, 17, 23, 18, 38]
        ]
      };

      optionsDailySalesChart = {
        lineSmooth: Chartist.Interpolation.cardinal({
          tension: 0
        }),
        low: 0,
        high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
        chartPadding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        },
      }

      var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

      var animationHeaderChart = new Chartist.Line('#websiteViewsChart', dataDailySalesChart, optionsDailySalesChart);
    }
  },


  initFormExtendedDatetimepickers: function() {
    $('.datetimepicker').datetimepicker({
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
      }
    });

    $('.datepicker').datetimepicker({
      format: 'MM/DD/YYYY',
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
      }
    });

    $('.timepicker').datetimepicker({
      //          format: 'H:mm',    // use this format if you want the 24hours timepicker
      format: 'h:mm A', //use this format if you want the 12hours timpiecker with AM/PM toggle
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'

      }
    });
  },


  initSliders: function() {
    // Sliders for demo purpose
    var slider = document.getElementById('sliderRegular');

    noUiSlider.create(slider, {
      start: 40,
      connect: [true, false],
      range: {
        min: 0,
        max: 100
      }
    });

    var slider2 = document.getElementById('sliderDouble');

    noUiSlider.create(slider2, {
      start: [20, 60],
      connect: true,
      range: {
        min: 0,
        max: 100
      }
    });
  },

  initSidebarsCheck: function() {
    if ($(window).width() <= 991) {
      if ($sidebar.length != 0) {
        md.initRightMenu();
      }
    }
  },

  checkFullPageBackgroundImage: function() {
    $page = $('.full-page');
    image_src = $page.data('image');

    if (image_src !== undefined) {
      image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>'
      $page.append(image_container);
    }
  },

  initDashboardPageCharts: function() {

    if ($('#dailySalesChart').length != 0 || $('#completedTasksChart').length != 0 || $('#websiteViewsChart').length != 0) {
      /* ----------==========     Daily Sales Chart initialization    ==========---------- */
      <?php
        $d = date('d');
        $d = (int) $d;
        $days = array();
        for ($i = 0; $i < 7; $i++) {
            $days[$i] =  $i+1;
            // $d--;
        }
        $days = implode(',', $days);
        $dailytotalorders = array();
        $todaydate = date('d');
        $initialvalue = $todaydate-6;
        // dd($initialvalue);
        for ($dt = $initialvalue; $dt<=$todaydate ; $dt++)  {
            $dailytotalorders[] = DB::table('orders')
            ->select('id')
            ->where('created_at','like',date('Y-m-').$dt.'%')
            ->count('id');
        }
        $mergetotalorders = implode(',', $dailytotalorders);
        // dd($mergetotalorders);
      ?>
      dataDailySalesChart = {
        labels: [<?php echo $days ?>],
        series: [
          [<?php echo $mergetotalorders?>]
        ]
      };

      optionsDailySalesChart = {
        lineSmooth: Chartist.Interpolation.cardinal({
          tension: 0
        }),
        low: 0,
        high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
        chartPadding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        },
      }

      var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

      md.startAnimationForLineChart(dailySalesChart);



      /* ----------==========     Completed Tasks Chart initialization    ==========---------- */
       <?php
        $d = date('d');
        $d = (int) $d;
        $days = array();
        for ($i = 0; $i < 7; $i++) {
            $days[$i] =  $i+1;
            // $d--;
        }
        $days = implode(',', $days);
      ?>
      dataCompletedTasksChart = {
        labels: [<?php echo ( $days );?>],
        series: [
          [0,0,0,0,0,0,0]
        ]
      };

      optionsCompletedTasksChart = {
        lineSmooth: Chartist.Interpolation.cardinal({
          tension: 0
        }),
        low: 0,
        high: 1000, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
        chartPadding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        }
      }

      var completedTasksChart = new Chartist.Line('#completedTasksChart', dataCompletedTasksChart, optionsCompletedTasksChart);

      // start animation for the Completed Tasks Chart - Line Chart
      md.startAnimationForLineChart(completedTasksChart);


      /* ----------==========     Emails Subscription Chart initialization    ==========---------- */
      <?php
        $d = date('t');
        $d = (int) $d;
        $days = array();
        for ($i = 0; $i < $d; $i++) {
            $days[$i] =  $i+1;
        }
        $days = implode(',', $days);
        $dailytotalorders = array();
        $todaydate = date('d');
        $initialvalue = $todaydate-6;
        // dd($initialvalue);
        for ($dt = 1; $dt<=$d ; $dt++)  {
            if ($dt <= 9) {
                $dailyviews[] = DB::table('webvisit')
                ->select('webvisit_id')
                ->where('webvisit_at','like',date('Y-m-').'0'.$dt.'%')
                ->count('webvisit_id');    
            }else{
                $dailyviews[] = DB::table('webvisit')
                ->select('webvisit_id')
                ->where('webvisit_at','like',date('Y-m-').$dt.'%')
                ->count('webvisit_id');
            }
        }
        $mergetotalorders = implode(',', $dailyviews);
        // dd($mergetotalorders);
      ?>
      var dataWebsiteViewsChart = {
        labels: [<?php echo( $days )?>],
        series: [
          [<?php echo( $mergetotalorders )?>]

        ]
      };
      var optionsWebsiteViewsChart = {
        axisX: {
          showGrid: false
        },
        low: 0,
        high: 1000,
        chartPadding: {
          top: 0,
          right: 5,
          bottom: 0,
          left: 0
        }
      };
      var responsiveOptions = [
        ['screen and (max-width: 640px)', {
          seriesBarDistance: 5,
          axisX: {
            labelInterpolationFnc: function(value) {
              return value[0];
            }
          }
        }]
      ];
      var websiteViewsChart = Chartist.Bar('#websiteViewsChart', dataWebsiteViewsChart, optionsWebsiteViewsChart, responsiveOptions);

      //start animation for the Emails Subscription Chart
      md.startAnimationForBarChart(websiteViewsChart);
    }
  },

  initMinimizeSidebar: function() {

    $('#minimizeSidebar').click(function() {
      var $btn = $(this);

      if (md.misc.sidebar_mini_active == true) {
        $('body').removeClass('sidebar-mini');
        md.misc.sidebar_mini_active = false;
      } else {
        $('body').addClass('sidebar-mini');
        md.misc.sidebar_mini_active = true;
      }

      // we simulate the window Resize so the charts will get updated in realtime.
      var simulateWindowResize = setInterval(function() {
        window.dispatchEvent(new Event('resize'));
      }, 180);

      // we stop the simulation of Window Resize after the animations are completed
      setTimeout(function() {
        clearInterval(simulateWindowResize);
      }, 1000);
    });
  },

  checkScrollForTransparentNavbar: debounce(function() {
    if ($(document).scrollTop() > 260) {
      if (transparent) {
        transparent = false;
        $('.navbar-color-on-scroll').removeClass('navbar-transparent');
      }
    } else {
      if (!transparent) {
        transparent = true;
        $('.navbar-color-on-scroll').addClass('navbar-transparent');
      }
    }
  }, 17),


  initRightMenu: debounce(function() {
    $sidebar_wrapper = $('.sidebar-wrapper');

    if (!mobile_menu_initialized) {
      $navbar = $('nav').find('.navbar-collapse').children('.navbar-nav');

      mobile_menu_content = '';

      nav_content = $navbar.html();

      nav_content = '<ul class="nav navbar-nav nav-mobile-menu">' + nav_content + '</ul>';

      navbar_form = $('nav').find('.navbar-form').get(0).outerHTML;

      $sidebar_nav = $sidebar_wrapper.find(' > .nav');

      // insert the navbar form before the sidebar list
      $nav_content = $(nav_content);
      $navbar_form = $(navbar_form);
      $nav_content.insertBefore($sidebar_nav);
      $navbar_form.insertBefore($nav_content);

      $(".sidebar-wrapper .dropdown .dropdown-menu > li > a").click(function(event) {
        event.stopPropagation();

      });

      // simulate resize so all the charts/maps will be redrawn
      window.dispatchEvent(new Event('resize'));

      mobile_menu_initialized = true;
    } else {
      if ($(window).width() > 991) {
        // reset all the additions that we made for the sidebar wrapper only if the screen is bigger than 991px
        $sidebar_wrapper.find('.navbar-form').remove();
        $sidebar_wrapper.find('.nav-mobile-menu').remove();

        mobile_menu_initialized = false;
      }
    }
  }, 200),

  startAnimationForLineChart: function(chart) {

    chart.on('draw', function(data) {
      if (data.type === 'line' || data.type === 'area') {
        data.element.animate({
          d: {
            begin: 600,
            dur: 700,
            from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
            to: data.path.clone().stringify(),
            easing: Chartist.Svg.Easing.easeOutQuint
          }
        });
      } else if (data.type === 'point') {
        seq++;
        data.element.animate({
          opacity: {
            begin: seq * delays,
            dur: durations,
            from: 0,
            to: 1,
            easing: 'ease'
          }
        });
      }
    });

    seq = 0;
  },
  startAnimationForBarChart: function(chart) {

    chart.on('draw', function(data) {
      if (data.type === 'bar') {
        seq2++;
        data.element.animate({
          opacity: {
            begin: seq2 * delays2,
            dur: durations2,
            from: 0,
            to: 1,
            easing: 'ease'
          }
        });
      }
    });

    seq2 = 0;
  },


  initFullCalendar: function() {
    $calendar = $('#fullCalendar');

    today = new Date();
    y = today.getFullYear();
    m = today.getMonth();
    d = today.getDate();

    $calendar.fullCalendar({
      viewRender: function(view, element) {
        // We make sure that we activate the perfect scrollbar when the view isn't on Month
        if (view.name != 'month') {
          $(element).find('.fc-scroller').perfectScrollbar();
        }
      },
      header: {
        left: 'title',
        center: 'month,agendaWeek,agendaDay',
        right: 'prev,next,today'
      },
      defaultDate: today,
      selectable: true,
      selectHelper: true,
      views: {
        month: { // name of view
          titleFormat: 'MMMM YYYY'
          // other view-specific options here
        },
        week: {
          titleFormat: " MMMM D YYYY"
        },
        day: {
          titleFormat: 'D MMM, YYYY'
        }
      },

      select: function(start, end) {

        // on select we show the Sweet Alert modal with an input
        swal({
            title: 'Create an Event',
            html: '<div class="form-group">' +
              '<input class="form-control" placeholder="Event Title" id="input-field">' +
              '</div>',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
          }).then(function(result) {

            var eventData;
            event_title = $('#input-field').val();

            if (event_title) {
              eventData = {
                title: event_title,
                start: start,
                end: end
              };
              $calendar.fullCalendar('renderEvent', eventData, true); // stick? = true
            }

            $calendar.fullCalendar('unselect');

          })
          .catch(swal.noop);
      },
      editable: true,
      eventLimit: true, // allow "more" link when too many events


      // color classes: [ event-blue | event-azure | event-green | event-orange | event-red ]
      events: [{
          title: 'All Day Event',
          start: new Date(y, m, 1),
          className: 'event-default'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: new Date(y, m, d - 4, 6, 0),
          allDay: false,
          className: 'event-rose'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: new Date(y, m, d + 3, 6, 0),
          allDay: false,
          className: 'event-rose'
        },
        {
          title: 'Meeting',
          start: new Date(y, m, d - 1, 10, 30),
          allDay: false,
          className: 'event-green'
        },
        {
          title: 'Lunch',
          start: new Date(y, m, d + 7, 12, 0),
          end: new Date(y, m, d + 7, 14, 0),
          allDay: false,
          className: 'event-red'
        },
        {
          title: 'Md-pro Launch',
          start: new Date(y, m, d - 2, 12, 0),
          allDay: true,
          className: 'event-azure'
        },
        {
          title: 'Birthday Party',
          start: new Date(y, m, d + 1, 19, 0),
          end: new Date(y, m, d + 1, 22, 30),
          allDay: false,
          className: 'event-azure'
        },
        {
          title: 'Click for Creative Tim',
          start: new Date(y, m, 21),
          end: new Date(y, m, 22),
          url: 'http://www.creative-tim.com/',
          className: 'event-orange'
        },
        {
          title: 'Click for Google',
          start: new Date(y, m, 21),
          end: new Date(y, m, 22),
          url: 'http://www.creative-tim.com/',
          className: 'event-orange'
        }
      ]
    });
  },

  initVectorMap: function() {
    var mapData = {
      "AU": 760,
      "BR": 550,
      "CA": 120,
      "DE": 1300,
      "FR": 540,
      "GB": 690,
      "GE": 200,
      "IN": 200,
      "RO": 600,
      "RU": 300,
      "US": 2920,
    };

    $('#worldMap').vectorMap({
      map: 'world_mill_en',
      backgroundColor: "transparent",
      zoomOnScroll: false,
      regionStyle: {
        initial: {
          fill: '#e4e4e4',
          "fill-opacity": 0.9,
          stroke: 'none',
          "stroke-width": 0,
          "stroke-opacity": 0
        }
      },

      series: {
        regions: [{
          values: mapData,
          scale: ["#AAAAAA", "#444444"],
          normalizeFunction: 'polynomial'
        }]
      },
    });
  }
}

// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.

function debounce(func, wait, immediate) {
  var timeout;
  return function() {
    var context = this,
      args = arguments;
    clearTimeout(timeout);
    timeout = setTimeout(function() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    }, wait);
    if (immediate && !timeout) func.apply(context, args);
  };
};
var detailsBox = document.getElementById('details-box');
document.addEventListener('mouseover', function (e) {
      if (e.target.tagName == 'path') {
    var content = e.target.dataset.name;
    detailsBox.innerHTML = content;
    detailsBox.style.opacity = "100%";
  }
  else {
    detailsBox.style.opacity = "0%";
  }
});
window.onmousemove = function (e) {
  var x = e.clientX,
      y = e.clientY;
  detailsBox.style.top = (y + 20) + 'px';
  detailsBox.style.left = (x) + 'px';
};
</script>
<script src="{{asset('public/assets/js/mode.js')}}"></script>

     
@endsection
