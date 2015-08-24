/**
 * Created by chadwindnagle on 8/24/15.
 */

var Retailers = {
    count: 0,
    status: false,
    retailersList: 0,

    /*
     * Poll the session to see if we have geo data yet
     *
     * Note this will repeat till the clear interval is hit
     */
    JGeoPoll: function() {
        // one sanity check to make sure we don't start this up
        // unless we really need it
        if (this.status) {
            return;
        }

        var checkStatus = setInterval(function() {
            // execute ajax functions
            Retailers.getAjaxStatus();

            // once we have the status please stop!
            if (Retailers.status) {
                clearInterval(checkStatus);
            }

        }, 2000); // in ms
    },

    getAjaxStatus: function(){
        jQuery.ajax({
            url: JGeo.getBase(),
            data: {
                option: 'com_ajax',
                module: 'retailers',
                method: 'retailers',
                format: 'json'
            }
        }).success(function(response) {
            Retailers.status = response.data.status;
            Retailers.retailersList = response.data.retailers;
        }).error(function() {
            console.log('there was an error fetching retailers');
        });
    },

    /*
     * process the items here
     */
    addRetailers: function(retailers) {

    }
};