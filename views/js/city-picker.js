/* =========================================================
 * city-picker.js 
 * Copyright 2014 HApPy Studio (http://www.zjhzxhz.com)
 *
 * @author: 谢浩哲 <zjhzxhz@gmail.com>
 * Modified By Dante <d.ebony.ivory@gmail.com> 2015.5
 * =========================================================
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, 
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */
 

////////////////////////////////////////////////////////////////////////////
//                                  Data                                  //
////////////////////////////////////////////////////////////////////////////
var province = Object();

province['华东地区'] 	= '上海市|江苏省|安徽省|浙江省';

////////////////////////////////////////////////////////////////////////////

var city = Object();

// 华东地区
city['江苏省'] 			= '南京市|徐州市|连云港市|宿迁市|淮安市|盐城市|扬州市|泰州市|南通市|镇江市|常州市|无锡市|苏州市';
city['安徽省'] 			= '合肥市|宿州市|淮北市|阜阳市|蚌埠市|淮南市|滁州市|马鞍山市|芜湖市|铜陵市|安庆市|黄山市|六安市|池州市|宣城市|亳州市';
city['浙江省'] 			= '杭州市|宁波市|湖州市|嘉兴市|舟山市|绍兴市|衢州市|金华市|台州市|温州市|丽水市';
city['上海市'] 			= '黄浦区|静安区|徐汇区|闵行区|长宁区|普陀区|宝山区|杨浦区|闸北区|虹口区|嘉定区|松江区|青浦区|南汇区|金山区|奉贤区|浦东新区';

////////////////////////////////////////////////////////////////////////////

(function($){
    $.fn.cityPicker = function(settings){
        if ( $(this).length < 1 )   return;

        var cityPickerObject        = $(this),
            regionSelectorObject    = $('.region', this),
            provinceSelectorObject  = $('.province', this),
            citySelectorObject      = $('.city', this);

        // Default Settings
        settings = $.extend({
            required: true
        }, settings);

        var setProvince = function() {
            var provinceArray   = [],
                regionName = '华东地区';

            provinceSelectorObject.empty();
            if ( province[regionName] ) {
                provinceArray = province[regionName].split('|');
                if ( !settings['required'] ) {
                    provinceSelectorObject.append('<option value="">任意省份</option>');
                }
                for (var i = 0; i < provinceArray.length; i++) {
                    provinceSelectorObject.append('<option value="' + provinceArray[i] + '">' + provinceArray[i] + '</option>');
                }
                provinceSelectorObject.removeAttr('disabled');
            } else {
                provinceSelectorObject.attr('disabled', 'disabled');
            }
        }

        var setCity = function() {
            var cityArray       = [],
                provinceName    = $(provinceSelectorObject).find(':selected').val();
                // provinceName = '华东地区';

            citySelectorObject.empty();
            if ( city[provinceName] ) {
                cityArray = city[provinceName].split('|');
                if ( !settings['required'] ) {
                    citySelectorObject.append('<option value="">任意城市</option>');
                }
                for (var i = 0; i < cityArray.length; i++) {
                    citySelectorObject.append('<option value="' + cityArray[i] + '">' + cityArray[i] + '</option>');
                }
                citySelectorObject.removeAttr('disabled');
            } else {
                citySelectorObject.attr('disabled', 'disabled');
            }
        }

        var initializeCityPicker = function() {
            if ( settings['required'] ) {
                setProvince();
                setCity();
            } else {
                provinceSelectorObject.attr('disabled', 'disabled');
                citySelectorObject.attr('disabled', 'disabled');
            }

            regionSelectorObject.bind('change', function(){
                setProvince();
                setCity();
            });
            provinceSelectorObject.bind('change', function() {
                setCity();
            });
        }
        initializeCityPicker();
    }
})(jQuery);