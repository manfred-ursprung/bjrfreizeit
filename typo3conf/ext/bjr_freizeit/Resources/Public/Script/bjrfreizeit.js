
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Manfred Ursprung <manfred@manfred-ursprung.de>, Webapplikationen Ursprung
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * package  : bjrfreizeit
 */

jQuery(document).ready(function() {

    //initialize datepicker on search form
    $( "#leisureSearchStartDate" ).datepicker();
    $( "#leisureSearchEndDate" ).datepicker();

    $('.subkategorien li i').hide();
    //send search request per ajax
    $('.subkategorien li a').click(function (event) {

        event.preventDefault();
        $.fancybox({
            'width': '80%',
            'height': '80%',
            'closeBtn' : false,
            'autoScale': true,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'type': 'iframe',
            'content': $('.search-spinner').html()
        });
        var $this    = $(this);
        var url = 'index.php?type=14545';
        var category = $this.data('category');
        var property = $this.data('property');
        //$this.parents('ul').find('li a i').hide();
        $('.sidebar-left ul li a i').hide();
        $this.parents('ul').find('li a span').show();
        if($this.hasClass('filter-active')){
            property = '';
        }
        $.ajax({
            async: 'true',
            url: url,
            type: 'POST',

            data: {
                'tx_bjrfreizeit_search[action]': 'searchResult',
                'tx_bjrfreizeit_search[controller]': 'Search',
                'tx_bjrfreizeit_search[category]': category,
                'tx_bjrfreizeit_search[property]': property,
                'tx_bjrfreizeit_search[ajax]': true,

            },
            dataType: "json",
            //dataType: 'html',
            success: function (result) {
                console.log(result);
                $('.hauptinhalt>div').html(result.html);
                if($this.hasClass('filter-active')){
                    $this.removeClass('filter-active');
                    $this.find('span').show();
                }else {
                    $this.addClass('filter-active');
                    $this.find('span').hide();
                    $this.find('i').show();
                }
                $.fancybox.close();
            },
            error: function (error) {
                console.log(error);
                $.fancybox.close();
            }
        });
    });

    $("#leisure-search").submit(function(e){
        e.preventDefault();
        $.fancybox({
            'width': '80%',
            'height': '80%',
            'closeBtn' : false,
            'autoScale': true,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'type': 'iframe',
            'content': $('.search-spinner').html()
        });

        var url = 'index.php?type=14545';
        //var formData = $("#leisure-search").serializeArray();
        //var data = 'tx_bjrfreizeit_search[action]=searchResult&tx_bjrfreizeit_search[controller]=Search';
        var location = $('#leisureSearchLocation').val();
        var country  = $('#leisureSearchCountry').val();
        var organization = $('#leisureSearchOrganization').val();
        var priceFrom   = $('#leisureSearchPriceFrom').val();
        var priceTo   = $('#leisureSearchPriceTo').val();
        var startDate = $('#leisureSearchStartDate').val();
        var endDate = $('#leisureSearchEndDate').val();
        var description = $('#leisureSearchDescription').val();

        //data = encodeURIComponent(data);
        //console.log(data);
/*
        data['tx_bjrfreizeit_search[action'] = 'searchResult';
        data['tx_bjrfreizeit_search[controller'] = 'Search';
        data['tx_bjrfreizeit_search[location'] = 'Bayern';
*/
        $.ajax({
            async: 'true',
            url: url,
            type: 'POST',

            data: {
                'tx_bjrfreizeit_search[action]':        'searchResult',
                'tx_bjrfreizeit_search[controller]':    'Search',
                'tx_bjrfreizeit_search[location]':      location,
                'tx_bjrfreizeit_search[organization]':  organization,
                'tx_bjrfreizeit_search[country]':       country,
                'tx_bjrfreizeit_search[priceFrom]':     priceFrom,
                'tx_bjrfreizeit_search[priceTo]':       priceTo,
                'tx_bjrfreizeit_search[startDate]':     startDate,
                'tx_bjrfreizeit_search[endDate]':       endDate,
                'tx_bjrfreizeit_search[description]':   description,
                'tx_bjrfreizeit_search[ajax]':          true,
            },
            dataType: "json",
            //dataType: 'html',
            success: function (result) {
                console.log(result);
                $('.hauptinhalt>div').html(result.html);
                $.fancybox.close();

            },
            error: function (error) {
                console.log(error);
                $.fancybox.close();
            }
        });
        /*
         'tx_bjrfreizeit_search[action]=searchResult&tx_bjrfreizeit_search[controller]=Search&tx_bjrfreizeit_search[location]=Bayern'

         */
    });
});

