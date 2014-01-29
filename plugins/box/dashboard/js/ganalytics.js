if (typeof $.monstra == 'undefined') $.monstra = {};

function glibOnloadHandle(){$.monstra.ganalytics.libOnloadHandle();}

$.monstra.ganalytics = {

    conf: {
        clientId: '',
        apiKey: '',
        viewId: '',
        authScopes: 'https://www.googleapis.com/auth/analytics.readonly'
    },

    _gaAreas: '#authOk,#authFail,#gaSettings,#gaLoading,#reauthError,#gaHelpLink',
    _startDate: moment().subtract('days', 29),
    _endDate: moment(),
    
    init: function(data){
        $.extend(this.conf, data);
        $('.gaSettingsLink').click(function(){
            $.monstra.ganalytics.show('#gaSettings,#gaHelpLink');
			$('.gaSettingsLink').hide();
        });
    },
    
    initDateRangePicker: function(){
        $('#reportRange').daterangepicker({
              ranges: {
                 'Today': [moment(), moment()],
                 'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                 'Last 7 Days': [moment().subtract('days', 6), moment()],
                 'Last 30 Days': [moment().subtract('days', 29), moment()],
                 'This Month': [moment().startOf('month'), moment().endOf('month')],
                 'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
              },
              startDate: $.monstra.ganalytics._startDate,
              endDate: $.monstra.ganalytics._endDate
            },function(start, end) {
                $.monstra.ganalytics.getAnalyticsInfo(start._d, end._d);
            }
        );
        $.monstra.ganalytics.getAnalyticsInfo($.monstra.ganalytics._startDate._d, $.monstra.ganalytics._endDate._d);
    },
    
    libOnloadHandle: function(){
        if ($.monstra.ganalytics.conf.clientId == '' 
            || $.monstra.ganalytics.conf.apiKey == '' 
            || $.monstra.ganalytics.conf.viewId == ''
        ) {
            $.monstra.ganalytics.show('#gaSettings,#gaHelpLink');
			$('.gaSettingsLink').hide();
            return false;
        }
        gapi.client.setApiKey(this.conf.apiKey);
        window.setTimeout(function(){
            $.monstra.ganalytics.checkAuth(true);
        },1);
    },

    checkAuth: function(immediate){
        gapi.auth.authorize({
            client_id: $.monstra.ganalytics.conf.clientId,
            scope: $.monstra.ganalytics.conf.authScopes,
            immediate: immediate
        }, $.monstra.ganalytics.handleAuthResult);
        return immediate;
    },

    handleAuthResult: function(authResult){
        if (authResult && !authResult.error) {
            $.monstra.ganalytics.show('#authOk');
            $.monstra.ganalytics.initDateRangePicker();
        } else {
            $.monstra.ganalytics.show('#authFail');
            if (authResult && typeof authResult.error != 'undefined') {
                $.monstra.ganalytics.showError(authResult.error.message);
            }
            
            $('#authorizeButton').on('click', function(e){
                $.monstra.ganalytics.checkAuth(false);
            });
        }
    },

    getAnalyticsInfo: function(startDate, endDate) {
        gapi.client.load('analytics', 'v3', function(){
            gapi.client.analytics.data.ga.get({
                'ids': 'ga:'+ $.monstra.ganalytics.conf.viewId,
                'start-date': $.monstra.ganalytics.formatDate(startDate),
                'end-date': $.monstra.ganalytics.formatDate(endDate),
                'metrics': 'ga:visits,ga:pageviews,ga:visitors',
                'dimensions': 'ga:date'
            }).execute($.monstra.ganalytics.gaReportingResults);
        });
    },

    gaReportingResults: function(res){
        if (typeof res.error != 'undefined' && typeof res.error.message != 'undefined') {
            $.monstra.ganalytics.showError(res.error.message, res.error.code);
            return;
        }
        
        // build chart data
        var dataArr = [['Date', 'Visits']];
        for (r in res.rows) {
            var tmpr = [];
            for (h in res.columnHeaders) {
                if (res.columnHeaders[h].name == 'ga:visits') {
                    tmpr[1] = parseInt(res.rows[r][h]);
                } else if (res.columnHeaders[h].name == 'ga:date') {
                    var parsed = res.rows[r][h].match(/([0-9]{4})([0-9]{2})([0-9]{2})/)
                    tmpr[0] = parsed[1] +'-'+ parsed[2] +'-'+ parsed[3];
                }
                
                if (res.rows.length == (parseInt(r)+1)) {
                    switch(res.columnHeaders[h].name) {
                        case 'ga:visits': $.monstra.ganalytics.setVisits(res.rows[r][h]); break;
                        case 'ga:pageviews': $.monstra.ganalytics.setPageviews(res.rows[r][h]); break;
                        case 'ga:visitors': $.monstra.ganalytics.setVisitors(res.rows[r][h]); break;
                    }
                }
            }
            dataArr.push(tmpr);
        }
        
        var data = google.visualization.arrayToDataTable(dataArr);

        var options = {
          title: 'Visits',
          hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('gaChart'));
        chart.draw(data, options);
        
    },

    formatDate: function(dateObj){
        var m = dateObj.getMonth()+1;
        var d = dateObj.getDate();
        m = m > 9 ? m : '0'+m;
        d = d > 9 ? d : '0'+d;
        return dateObj.getFullYear() +'-'+ m +'-'+ d;
    },

    show: function(selector){
		$('.gaSettingsLink').show();
        $('#gaAlerts').html('');
        $($.monstra.ganalytics._gaAreas).addClass('hide');
        $(selector).removeClass('hide').show();
    },

    showError: function(msg, errCode){
		if (typeof errCode !== 'undefined' && errCode == 403) {
			$.monstra.ganalytics.show('#reauthError,#gaHelpLink');
		} else {
			$.monstra.ganalytics.show('#gaHelpLink');
		}
        $('#gaAlerts').html(msg);
		$('#authOk').addClass('hide');
    },
    
    setVisits: function(val){
        $('#gaVisits').html(val);
    },
    
    setVisitors: function(val){
        $('#gaVisitors').html(val);
    },
    
    setPageviews: function(val){
        $('#gaPageviews').html(val);
    }
};

$(document).ready(function(){
    $val_gaInitData = $('#gaInitData').val();
    if ($val_gaInitData !== undefined) {
        $.monstra.ganalytics.init($.parseJSON($val_gaInitData));
    }
});

