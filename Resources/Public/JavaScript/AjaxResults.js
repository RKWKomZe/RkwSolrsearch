
function SearchController() {
    let _this = this;

    this.settings = {
        ajaxType: 7383,
        solrSearchContainerId: '#tx-solr-search-functions',
        solrSearchContainer: null,
        solrContainerClass: '.tx_solr.container.main',
        solrContainer: null,
        solrContainerParent: null,
        solrItemContainerClass: ".solr-item-container",
        solrMoreButtonClass: ".solr-more-button",
        loadingIndicatorActiveClass: 'is-ajax-loading',
        loadingIndicatorTargetClass: 'is-ajax-target',
        loadingIndicatorHtml: '<div class="loading-indicator"></div>',
        loadingIndicatorHtmlClass: 'ajax-overlay',
        filterString: 'filter'
    };

    this.init = function () {

        jQuery("body").delegate(
            "a.solr-ajaxified, .checkbox.solr-ajaxified",
            "click",
            _this.handleClickOnAjaxifiedUri
        );

        jQuery("body").delegate(
            "select.solr-ajaxified",
            "change",
            _this.handleClickOnAjaxifiedUri
        )

        jQuery("body").delegate(
            "form.solr-ajaxified",
            "submit",
            _this.handleClickOnAjaxifiedUri
        );

        jQuery("body").on("tx_solr_updated", function (event, uri) {

          if (uri._parts.query.includes(_this.settings.filterString)) {
              _this.expandFilter();
          }

          jQuery(".accordion-control").accordionPlugin();
          _this.removeLoadingIndicator();
          //history.replaceState({}, null, uri.removeQuery("type").href());
        });

    };

    this.expandFilter = function () {

      jQuery('.accordion-filter .accordion-control')
        .attr("aria-expanded", "true");
      jQuery('.accordion-filter .accordion__item-content')
        .attr("aria-hidden", "false")
        .slideDown({duration: 500, queue: false});

    },

    this.handleClickOnAjaxifiedUri = function () {

        let $el = jQuery(this);
        let uri = '';

        _this.settings.solrContainer = $el.closest(_this.settings.solrContainerClass);
        _this.settings.solrContainerParent = _this.settings.solrContainer.parent();
        _this.settings.solrSearchContainer = $el.closest(_this.settings.solrSearchContainerId);

        uri = _this.buildUri($el);
        uri.addQuery("type", _this.settings.ajaxType);

        _this.addLoadingIndicator();

        jQuery.get(
            uri.href(),
            function (data) {

                // if "this" has attribute for action, use it. Otherwise, always do replace
                let action = 'replace';
                if ($el.attr('data-solr-ajax-action')) {
                    action = $el.attr('data-solr-ajax-action');
                }

                if (action === 'replace') {

                    _this.settings.solrContainer = _this.settings.solrContainer.replaceWith(jQuery(data).find(_this.settings.solrContainerClass));
                    history.replaceState({}, null, uri.removeQuery("type").href());

                } else {

                    // append content
                    jQuery(_this.settings.solrItemContainerClass).append(jQuery(data).find(_this.settings.solrItemContainerClass + " .flex-item"));

                    // replace button (if exists)
                    if (jQuery(data).find(_this.settings.solrMoreButtonClass).length > 0) {
                        jQuery(_this.settings.solrMoreButtonClass).replaceWith(jQuery(data).find(_this.settings.solrMoreButtonClass));
                    } else {
                        jQuery(_this.settings.solrMoreButtonClass).replaceWith('');
                    }
                }

            //    _this.scrollToTopOfElement(_this.setings.solrContainerParent, 50);
                jQuery("body").trigger("tx_solr_updated", [uri]);

            }
        );
        return false;
    };

    this.buildUri = function ($el) {

      let uri = '';

      if ($el.is("select")) {

        uri = URI($el.val());

      } else if ($el.is("form")) {

        let fieldName = "tx_solr[q]";
        let action = $el.attr('action');
        let term = $el.find('input[name="' + fieldName + '"]').val()

        //uri = URI(action + '?' + fieldName + '=' + term);
        uri = URI(action).addSearch(fieldName, term);

      } else if ($el.is('input[type="checkbox"]')) {

        uri = URI($el.data("facet-uri"));

      } else {

        // "a"
        uri = $el.uri();
      }

      return uri;
    };

    this.addLoadingIndicator = function () {

        const html = jQuery.parseHTML('<div class="' + _this.settings.loadingIndicatorHtmlClass + '">' + _this.settings.loadingIndicatorHtml + '</div>');

        _this.settings.solrSearchContainer
            .addClass(_this.settings.loadingIndicatorTargetClass)
            .blur()
            .append(html)
        ;

    };

    this.removeLoadingIndicator = function () {

      _this.settings.solrSearchContainer
        .find('.' + _this.settings.loadingIndicatorHtmlClass)
        .blur()
        .remove();

      _this.settings.solrSearchContainer
        .removeClass(_this.settings.loadingIndicatorTargetClass);

    };

    /*
    this.scrollToTopOfElement = function(element, deltaTop) {
        jQuery('html, body').animate({
            scrollTop: (element.offset().top - deltaTop) + 'px'
        }, 'slow');
    };
     */

}

jQuery(document).ready(function() {

    let solrSearchController = new SearchController();
    solrSearchController.init();

});
