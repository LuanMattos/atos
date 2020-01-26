if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
var dashboard_activity = {
    Url: function (metodo, params) {
        return App.url("dashboard_activity", "Dashboard_activity", metodo, params);
    }

};

var vue_instance_dashboard_activity = new Vue({


    });

