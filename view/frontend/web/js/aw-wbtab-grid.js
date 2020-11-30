/**
* Copyright 2019 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

/**
 * Initialization widget for grid block
 *
 * @method hideWbtabExcessItems()
 */
define([
    'jquery'
], function($) {
    "use strict";

    $.widget('mage.awWbtabGrid', {
        options: {
            itemsSelector: '[data-aw-wbtab-block="items"]'
        },

        /**
         * Initialize widget
         */
        _create: function() {
            this.hideWbtabExcessItems();
            $(window).on('resize', $.proxy(this.hideWbtabExcessItems, this));
        },

        /**
         * Show wbtab items to fit one row
         */
        hideWbtabExcessItems: function() {
            var grid = $(this.options.itemsSelector);

            if (!grid) {
                return;
            }
            var gridItems = grid.children(),
                gridWidth = grid.width(),
                itemWidth = gridItems.first().outerWidth(),
                itemsToShow = Math.round(gridWidth/itemWidth);

            gridItems.each(function(index, item) {
                if (index < itemsToShow) {
                    $(item).show();
                } else {
                    $(item).hide();
                }
            })
        }
    });

    return $.mage.awWbtabGrid;
});
