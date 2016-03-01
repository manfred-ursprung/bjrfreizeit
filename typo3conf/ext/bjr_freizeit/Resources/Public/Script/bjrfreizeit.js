
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

    $('.subkategorien li i').hide();
    //send search request per ajax
    $('.subkategorien li a').click(function (event) {

        event.preventDefault();
        var $this    = $(this);
        var url = 'index.php?type=14545';
        var category = $this.data('category');
        var property = $this.data('property');
        $this.parents('ul').find('li a i').hide();
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

            },
            dataType: "json",
            //dataType: 'html',
            success: function (result) {
                console.log(result);
                $('.hauptinhalt>div').html(result.html);
                if($this.hasClass('filter-active')){
                    $this.removeClass('filter-active');
                }else {
                    $this.addClass('filter-active');
                    $this.find('span').hide();
                    $this.find('i').show();
                }

            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});

