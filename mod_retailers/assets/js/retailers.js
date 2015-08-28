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
                Retailers.addRetailers();
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
    addRetailers: function() {
        var locations = Retailers.retailersList;
        var html = '';

        if (locations.length == 0) {
            var html = '<p><a href="/find-retailer">No Retailers Found. Try again.</a></p>'
            jQuery('#quick-retailers').html(html);
            return;
        }

        jQuery.each(locations, function(index, location) {
            html += Retailers.makeAccordion(index, location)
        });

        jQuery('#quick-retailers').html(html);
    },

    /*
     * Build an accordion selector
     */
    makeAccordion: function(index, location)
    {
        var html = '';
        html += '<div class="accordion-group">';
        html += '<div class="accordion-heading">';
        html += '<a class="accordion-toggle" data-toggle="collapse" data-parent="#quick-retailers" href="#tab' + index +'">';
        html += location.location_name;
        html += '</a>';

        html += '<div id="tab' + index +'" class="accordion-body collapse">';
        html += '<div class="accordion-inner">';
        html += '<p>Phone: <a href="tel:' + location.location_phone + '">';
        html += location.location_phone;
        html += '</a></p>';
        html += '<p>' + location.location_address + '<br />';
        html += location.location_city + ", " + location.location_state + " " + location.location_zip;
        html += '</p></div></div>';

        html += '</div></div>';

        return html;
    }
};