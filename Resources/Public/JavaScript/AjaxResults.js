
function SearchController() {
    var _this = this;

    _this.ajaxType = 7383;

    this.init = function() {

        jQuery("body").delegate(
            "a.solr-ajaxified, select.solr-ajaxified option, .checkbox.solr-ajaxified",
            "click",
            _this.handleClickOnAjaxifiedUri
        );

        jQuery("body").delegate(
            "form.solr-ajaxified",
            "submit",
            _this.handleClickOnAjaxifiedUri
        );
    };

    this.handleClickOnAjaxifiedUri = function() {

        var clickedLink = jQuery(this);

        var solrContainerClass = ".tx_solr.container.main";
        var solrContainer = clickedLink.closest(solrContainerClass);
        var solrItemContainerClass = ".solr-item-container";
        var solrMoreButtonClass = ".solr-more-button";

       // console.log('test');
       // console.log(clickedLink);

        var solrParent = solrContainer.parent();

        //var loader = jQuery("<div class='tx-solr-loader'></div>");

        var uri = '';

        if (jQuery(clickedLink).is("option")) {

            uri = URI(jQuery(clickedLink).val());

        } else if (jQuery(clickedLink).is("form")) {

            var fieldName = "tx_solr[q]";
            var action = jQuery(clickedLink).attr('action');
            var term = jQuery(clickedLink).find('input[name="' + fieldName + '"]').val()

            //uri = URI(action + '?' + fieldName + '=' + term);
            uri = URI(action).addSearch(fieldName, term);
        } else if (jQuery(clickedLink).is('input[type="checkbox"]')) {
            uri = URI(jQuery(clickedLink).data("target"));
        } else {

            // "a"
            uri = clickedLink.uri();
        }


        //solrParent.append(loader);
        uri.addQuery("type", _this.ajaxType);

        jQuery.get(
            uri.href(),
            function(data) {

                // if "this" has attribute for action, use it. Otherwise, always do replace
                var action = 'replace';
                if (jQuery(clickedLink).attr('data-solr-ajax-action')) {
                    action = jQuery(clickedLink).attr('data-solr-ajax-action');
                }

                if (action === 'replace') {

                    solrContainer = solrContainer.replaceWith(jQuery(data).find(solrContainerClass));

                    history.replaceState({}, null, uri.removeQuery("type").href());

                } else {

                    // append content
                    jQuery(solrItemContainerClass).append(jQuery(data).find(solrItemContainerClass + " .flex-item"));

                    // replace button (if exists)
                    if (jQuery(data).find(solrMoreButtonClass).length > 0) {
                        jQuery(solrMoreButtonClass).replaceWith(jQuery(data).find(solrMoreButtonClass));
                    } else {
                        jQuery(solrMoreButtonClass).replaceWith('');
                    }
                }


            //    _this.scrollToTopOfElement(solrParent, 50);
                jQuery("body").trigger("tx_solr_updated");
                //loader.fadeOut().remove();
                //history.replaceState({}, null, uri.removeQuery("type").href());

            }
        );
        return false;
    };

    /*
    this.scrollToTopOfElement = function(element, deltaTop) {
        jQuery('html, body').animate({
            scrollTop: (element.offset().top - deltaTop) + 'px'
        }, 'slow');
    };
     */

    this.setAjaxType = function(ajaxType) {
        _this.ajaxType = ajaxType;
    };
}

jQuery(document).ready(function() {
    var solrSearchController = new SearchController();
    solrSearchController.init();

    if(typeof solrSearchAjaxType !== "undefined") {
        solrSearchController.setAjaxType(solrSearchAjaxType);
    }
});
