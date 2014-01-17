if (typeof $.monstra == 'undefined') $.monstra = {};

function glibOnloadHandle(){$.monstra.ganalytics.libOnloadHandle();}

$.monstra.ganalytics = {

    conf: {
        clientId: '',
        apiKey: '',
        viewId: '',
        authScopes: 'https://www.googleapis.com/auth/analytics.readonly'
    },

    _gaAreas: '#authOk,#authFail,#gaSettings,#gaLoading',
    
    init: function(data){
        $.extend(this.conf, data);
    },

    libOnloadHandle: function(){
        if ($.monstra.ganalytics.conf.clientId == '' 
            || $.monstra.ganalytics.conf.apiKey == '' 
            || $.monstra.ganalytics.conf.viewId == ''
        ) {
            $.monstra.ganalytics.show('#gaSettings');
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
            $.monstra.ganalytics.getAnalyticsInfo();
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

    getAnalyticsInfo: function() {
        gapi.client.load('analytics', 'v3', function(){
            var dateOffset = (24*60*60*1000) * 30;
            var cdate = new Date();
            var mdate = new Date(cdate.getTime() - dateOffset);
            gapi.client.analytics.data.ga.get({
                'ids': 'ga:'+ $.monstra.ganalytics.conf.viewId,
                'start-date': $.monstra.ganalytics.formatDate(mdate),
                'end-date': $.monstra.ganalytics.formatDate(cdate),
                'metrics': 'ga:visits,ga:pageviews,ga:visitors',
                'dimensions': 'ga:date'
            }).execute($.monstra.ganalytics.gaReportingResults);
        });
    },

    gaReportingResults: function(res){
        if (typeof res.error != 'undefined' && typeof res.error.message != 'undefined') {
            $.monstra.ganalytics.showError(res.error.message);
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
                    tmpr[0] = res.rows[r][h];
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
        $('#gaAlerts').html('');
        $($.monstra.ganalytics._gaAreas).addClass('hide');
        $(selector).removeClass('hide').show();
    },

    showError: function(msg){
        $('#gaAlerts').html(msg);
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
    $.monstra.ganalytics.init($.parseJSON($('#gaInitData').val()));
});

