$(document).ready(function() {


    $("#a_open_wo").click(function() {
        var wo_count = $("#span_open_wo").html();
        var wo_condition = $(".span_select").html();

        var filePath = '../view/ticket_search_opened.php?wo_count=' + wo_count + '&wo_condition=' + wo_condition + '&wo_type=open';
        window.open(filePath);


    });
    $("#a_close_wo").click(function() {
        var wo_count = $("#span_close_wo").html();
        var wo_condition = $(".span_select").html();
        var filePath = '../view/ticket_search_opened.php?wo_count=' + wo_count + '&wo_condition=' + wo_condition + '&wo_type=close';
        window.open(filePath);


    });
    $("#a_complete_wo").click(function() {
        var wo_count = $("#span_complete_wo").html();
        var wo_condition = $(".span_select").html();
        var filePath = '../view/tickets_completed.php?wo_count=' + wo_count + '&wo_condition=' + wo_condition + '&wo_type=complete';
        window.open(filePath);


    });
    $("#a_pending_wo").click(function() {
        var wo_count = $("#span_pending_wo").html();
        var wo_condition = $(".span_select").html();
        var filePath = '../view/ticket_search_opened.php?wo_count=' + wo_count + '&wo_condition=' + wo_condition + '&wo_type=pending';
        window.open(filePath);


    });



    $("#a_today").click(function() {

        $(".span_select").html('Today');
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_today',
            criteria: 'opened'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_open_wo").html(obj.data[0].today_wo_opened);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_today',
            criteria: 'closed'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_close_wo").html(obj.data[0].today_wo_closed);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_today',
            criteria: 'pending'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_pending_wo").html(obj.data[0].today_wo_pending);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_today',
            criteria: 'completed'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_complete_wo").html(obj.data[0].today_wo_completed);
        });
    });
    $("#a_this_week").click(function() {

        $(".span_select").html('This Week');
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_week',
            criteria: 'opened'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_open_wo").html(obj.data[0].week_wo_opened);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_week',
            criteria: 'closed'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_close_wo").html(obj.data[0].week_wo_closed);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_week',
            criteria: 'pending'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_pending_wo").html(obj.data[0].week_wo_pending);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_week',
            criteria: 'completed'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_complete_wo").html(obj.data[0].week_wo_completed);
        });

    });
    $("#a_this_month").click(function() {

        $(".span_select").html('This Month');
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_month',
            criteria: 'opened'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_open_wo").html(obj.data[0].month_wo_opened);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_month',
            criteria: 'closed'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_close_wo").html(obj.data[0].month_wo_closed);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_month',
            criteria: 'pending'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_pending_wo").html(obj.data[0].month_wo_pending);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_month',
            criteria: 'completed'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_complete_wo").html(obj.data[0].month_wo_completed);
        });
    });
    $("#a_this_year").click(function() {

        $(".span_select").html('This Year');
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_year',
            criteria: 'opened'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_open_wo").html(obj.data[0].year_wo_opened);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_year',
            criteria: 'closed'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_close_wo").html(obj.data[0].year_wo_closed);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_year',
            criteria: 'pending'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_pending_wo").html(obj.data[0].year_wo_pending);
        });
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_year',
            criteria: 'completed'
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            $("#span_complete_wo").html(obj.data[0].year_wo_completed);
        });
    });


    var mm, yy;

    function graph_load(mm, yy, type) {
        var normal = 0;
        var urgent = 0;
        var emergency = 0;
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_normal_graph',
            month_val: mm,
            year_val: yy,
            category: type
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            normal = obj.data[0].wo_normal;

            $.post("../controller/dashboard/dashboard_controller.php", {
                action: 'check_wo_urgent_graph',
                month_val: mm,
                year_val: yy,
                category: type
            }, function(result, status) {
                var obj = jQuery.parseJSON(result);
                urgent = obj.data[0].wo_urgent;

                $.post("../controller/dashboard/dashboard_controller.php", {
                    action: 'check_wo_emergency_graph',
                    month_val: mm,
                    year_val: yy,
                    category: type
                }, function(result, status) {
                    var obj = jQuery.parseJSON(result);
                    emergency = obj.data[0].wo_emergency;

                    StatisticWidgets.init(normal, urgent, emergency);

                });

            });

        });
    }

    


    $("#category_select_type").change(function() {
        var months = $("#select_month").val();
        var years = $("#select_year").val();
        var month_text = $("#select_month option:selected").text();
        var categoryType = $("#category_select_type").val();
        var categoryTypeText = $("#category_select_type option:selected").text();
        var titleType = (categoryTypeText == "All") ? "All Category type" : categoryTypeText;
        titleType = (titleType == "CHOOSE") ? "" : titleType;
        $('#graph_category_type').html(titleType);
        var currentDate = new Date();
        if (months === 0 || months === null) {
            months = ("0" + (currentDate.getMonth() + 1)).slice(-2);
        }
        if (years === 0 || years === null) {
            years = currentDate.getFullYear();
        }
       
        $("#pie_basic").remove();
        $("#pie_basic_forAll").remove();
        var cmparedYM = years+'-'+months;
        if(categoryType=="all")
        {
            
            $('#loadPieForAll').load('dashboard/dashboard_piechart_all.php?yearmonth='+cmparedYM,function(result, status){
                console.log("status:"+status);
            });
            // $.post('dashboard/dashboard_piechart_all.php',
            // { yearMonth:cmparedYM },function(result,status){
            //     alert(yearMonth);
            // });
             $('#modalPieYM').html("All Category - "+months+'/'+years);
             $('#modal_forall_piechart').modal("show");
            // $("#modal_pie_chart").prepend('<div class="svg-center" id="pie_basic_forAll"></div>');
            // StatisticWidgetsForAll.init();
        }
        else
        {
            $('#modal_forall_piechart').modal("hide");
            $("#pie_card").prepend('<div class="svg-center" id="pie_basic"></div>');
            graph_load_typewise(months,years,categoryType);
        }
        //graph_load_typewise(months, years, categoryType);
    });


    $("#select_month").change(function() {

        var months = $("#select_month").val();
        var years = $("#select_year").val();
        var month_text = $("#select_month option:selected").text();
        var categoryType = $("#category_select_type").val();
        //var categoryTypeText = $("#category_select_type option:selected").text();
        //var titleType = (categoryTypeText == "All") ? "All Category type" : categoryTypeText;


        if (months != 0 && years != 0 && years != null && months != null) {

            $("#graph_title").html(month_text + ' ' + years);
            $("#pie_basic").remove();
            $("#pie_card").prepend('<div class="svg-center" id="pie_basic"></div>');
            graph_load(months, years, categoryType);
        } else {
            return false;
        }
    });


    $("#select_year").change(function() {

        var months = $("#select_month").val();
        var years = $("#select_year").val();
        var month_text = $("#select_month option:selected").text();
        var categoryType = $("#category_select_type").val();
        if (months != 0 && years != 0 && years != null && months != null) {
            $("#graph_title").html(month_text + ' ' + years);
            $("#pie_basic").remove();
            $("#pie_card").prepend('<div class="svg-center" id="pie_basic"></div>');
            graph_load(months, years, categoryType);
        } else {
            return false;
        }

    });

    $("#btn_dash_wo_search").click(function() {
        list_data();
    });
    list_data();

    function list_data() {

        var start_date = $('#txt_start_date').val();
        var end_date = $('#txt_end_date').val();
        var start = new Date(start_date);
        var end = new Date(end_date);
        var diff = new Date(end - start);
        var days = diff / 1000 / 60 / 60 / 24;


        if (start_date == '') {
            swal("Warning", "Please specify the start date ...", "warning");

            return false;
        } else if (end_date == '') {
            swal("Warning", "Please specify the end date ...", "warning");

            return false;
        } else if (days < 0) {
            swal("Warning", "Please provide a valid date range ...", "warning");

            return false;
        } else {

            $.ajax({
                type: "POST",
                url: "dashboard/dashboard_list_team_wo.php",
                data: {
                    start_date: start_date,
                    end_date: end_date
                }
            }).done(function(data) {

                $("#div_load_dashboard_wos").html(data);
            });
            // $.ajax({
            //     type: "POST",
            //     url: "dashboard/dashboard_list_team_wo.php",
            //     data: {
            //         start_date: start_date,
            //         end_date: end_date
            //     }
            // }).done(function(data) {
            //     if (data.trim() === "") {
            //         $("#div_load_dashboard_wos").html("No Data Available");
            //     } else {
            //         $("#div_load_dashboard_wos").html(data);
            //     }
            // });

        }

    }
    var categoryType;

    function graph_load_typewise(mm, yy, categoryType) {
        var normal = 0;
        var urgent = 0;
        var emergency = 0;
        $.post("../controller/dashboard/dashboard_controller.php", {
            action: 'check_wo_normal_graph_type',
            month_val: mm,
            year_val: yy,
            category: categoryType
        }, function(result, status) {
            var obj = jQuery.parseJSON(result);
            normal = obj.data[0].wo_normal;

            $.post("../controller/dashboard/dashboard_controller.php", {
                action: 'check_wo_urgent_graph_type',
                month_val: mm,
                year_val: yy,
                category: categoryType
            }, function(result, status) {
                var obj = jQuery.parseJSON(result);
                urgent = obj.data[0].wo_urgent;

                $.post("../controller/dashboard/dashboard_controller.php", {
                    action: 'check_wo_emergency_graph_type',
                    month_val: mm,
                    year_val: yy,
                    category: categoryType
                }, function(result, status) {
                    var obj = jQuery.parseJSON(result);
                    emergency = obj.data[0].wo_emergency;

                    StatisticWidgets.init(normal, urgent, emergency);

                });

            });

        });
    }




    $('.work-order-links').click(function() {
        var workOderNumber = $(this).data('id');
        window.open('tickets_search.php?workordrnumber=' + workOderNumber, '_blank');
    });

    $('.amc-renewal-click').click(function() {
        var amcrenewalNum = $(this).data('id');
        window.open('amc_renewal.php?amcnumber=' + amcrenewalNum, '_blank');
    });

     
    $('#btn_close_modalpie').click(function() {
        $('#modal_forall_piechart').modal("hide");
    });
    
    if ($.isEmptyObject(permissions)) {
      $('#divDashboardCalender, #divDashboardWOStatus, #divDashboardPieChart, #divDashboardTHCEmps, #divWORaisedMonthly, #divRaisedWO, #divAMCRenewals, #divActiveClients, #divCPRExpired, #divVisaExpired, #divWOTeamWise').addClass('overlay');
    }
    
    if ($.inArray("Dashboard", permissions) === -1) {
       $('#divDashboardCalender, #divDashboardWOStatus, #divDashboardPieChart, #divDashboardTHCEmps, #divWORaisedMonthly, #divRaisedWO, #divAMCRenewals, #divActiveClients, #divCPRExpired, #divVisaExpired, #divWOTeamWise').addClass('overlay');
    }
    
    if ($.inArray("CalenderView", permissions) === -1) {
       $('#divDashboardCalender').addClass('overlay');
    }
    
    if ($.inArray("WorkOrderReportsModule", permissions) === -1) {
       $('#divDashboardWOStatus, #divDashboardPieChart').addClass('overlay');
    }
    
    if ($.inArray("HRModule", permissions) === -1) {
       $('#divDashboardTHCEmps, #divWORaisedMonthly').addClass('overlay');
    }
    
    if ($.inArray("RenewAMC", permissions) === -1) {
       $('#divAMCRenewals').addClass('overlay');
    }
    
    if ($.inArray("CustomerView", permissions) === -1 || $.inArray("CustomerAndAssetsModule", permissions)=== -1) {
       $('#divActiveClients').addClass('overlay');
    }
    
    if ($.inArray("HRModule", permissions) === -1 || $.inArray("CPRAndVisaExpiryView", permissions)=== -1) {
       $('#divCPRExpired, #divVisaExpired').addClass('overlay');
    }
    
    if ($.inArray("WorkOrderReportsModule", permissions) === -1 || $.inArray("DailyTeamReport", permissions)=== -1) {
       $('#divWOTeamWise').addClass('overlay');
    }
    
    if ($.inArray("WorkOrderReportsModule", permissions) === -1 || $.inArray("WoReport", permissions)=== -1) {
       $('#divRaisedWO').addClass('overlay');
    }


});