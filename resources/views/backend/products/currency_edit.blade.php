<select id="currency" name="currency" class="form-control" style="direction: ltr;">
    <option disabled  style="direction: rtl;">اختر العملة</option>
    <option {{ old('currency',  $product->currency) == "AFN" ? 'selected' : null }} value="AFN">AFN - Afghan Afghani</option>
    <option {{ old('currency',  $product->currency) == "ALL" ? 'selected' : null }} value="ALL">ALL - Albanian Lek</option>
    <option {{ old('currency',  $product->currency) == "DZD" ? 'selected' : null }} value="DZD">DZD - Algerian Dinar</option>
    <option {{ old('currency',  $product->currency) == "AOA" ? 'selected' : null }} value="AOA">AOA - Angolan Kwanza</option>
    <option {{ old('currency',  $product->currency) == "ARS" ? 'selected' : null }} value="ARS">ARS - Argentine Peso</option>
    <option {{ old('currency',  $product->currency) == "AMD" ? 'selected' : null }} value="AMD">AMD - Armenian Dram</option>
    <option {{ old('currency',  $product->currency) == "AWG" ? 'selected' : null }} value="AWG">AWG - Aruban Florin</option>
    <option {{ old('currency',  $product->currency) == "AUD" ? 'selected' : null }} value="AUD">AUD - Australian Dollar</option>
    <option {{ old('currency',  $product->currency) == "AZN" ? 'selected' : null }} value="AZN">AZN - Azerbaijani Manat</option>
    <option {{ old('currency',  $product->currency) == "BSD" ? 'selected' : null }} value="BSD">BSD - Bahamian Dollar</option>
    <option {{ old('currency',  $product->currency) == "BHD" ? 'selected' : null }} value="BHD">BHD - Bahraini Dinar</option>
    <option {{ old('currency',  $product->currency) == "BDT" ? 'selected' : null }} value="BDT">BDT - Bangladeshi Taka</option>
    <option {{ old('currency',  $product->currency) == "BBD" ? 'selected' : null }} value="BBD">BBD - Barbadian Dollar</option>
    <option {{ old('currency',  $product->currency) == "BYR" ? 'selected' : null }} value="BYR">BYR - Belarusian Ruble</option>
    <option {{ old('currency',  $product->currency) == "BEF" ? 'selected' : null }} value="BEF">BEF - Belgian Franc</option>
    <option {{ old('currency',  $product->currency) == "BZD" ? 'selected' : null }} value="BZD">BZD - Belize Dollar</option>
    <option {{ old('currency',  $product->currency) == "BMD" ? 'selected' : null }} value="BMD">BMD - Bermudan Dollar</option>
    <option {{ old('currency',  $product->currency) == "BTN" ? 'selected' : null }} value="BTN">BTN - Bhutanese Ngultrum</option>
    <option {{ old('currency',  $product->currency) == "BTC" ? 'selected' : null }} value="BTC">BTC - Bitcoin</option>
    <option {{ old('currency',  $product->currency) == "BOB" ? 'selected' : null }} value="BOB">BOB - Bolivian Boliviano</option>
    <option {{ old('currency',  $product->currency) == "BAM" ? 'selected' : null }} value="BAM">BAM - Bosnia-Herzegovina Convertible Mark</option>
    <option {{ old('currency',  $product->currency) == "BWP" ? 'selected' : null }} value="BWP">BWP - Botswanan Pula</option>
    <option {{ old('currency',  $product->currency) == "BRL" ? 'selected' : null }} value="BRL">BRL - Brazilian Real</option>
    <option {{ old('currency',  $product->currency) == "GBP" ? 'selected' : null }} value="GBP">GBP - British Pound Sterling</option>
    <option {{ old('currency',  $product->currency) == "BND" ? 'selected' : null }} value="BND">BND - Brunei Dollar</option>
    <option {{ old('currency',  $product->currency) == "BGN" ? 'selected' : null }} value="BGN">BGN - Bulgarian Lev</option>
    <option {{ old('currency',  $product->currency) == "BIF" ? 'selected' : null }} value="BIF">BIF - Burundian Franc</option>
    <option {{ old('currency',  $product->currency) == "KHR" ? 'selected' : null }} value="KHR">KHR - Cambodian Riel</option>
    <option {{ old('currency',  $product->currency) == "CAD" ? 'selected' : null }} value="CAD">CAD - Canadian Dollar</option>
    <option {{ old('currency',  $product->currency) == "CVE" ? 'selected' : null }} value="CVE">CVE - Cape Verdean Escudo</option>
    <option {{ old('currency',  $product->currency) == "KYD" ? 'selected' : null }} value="KYD">KYD - Cayman Islands Dollar</option>
    <option {{ old('currency',  $product->currency) == "XOF" ? 'selected' : null }} value="XOF">XOF - CFA Franc BCEAO</option>
    <option {{ old('currency',  $product->currency) == "XAF" ? 'selected' : null }} value="XAF">XAF - CFA Franc BEAC</option>
    <option {{ old('currency',  $product->currency) == "XPF" ? 'selected' : null }} value="XPF">XPF - CFP Franc</option>
    <option {{ old('currency',  $product->currency) == "CLP" ? 'selected' : null }} value="CLP">CLP - Chilean Peso</option>
    <option {{ old('currency',  $product->currency) == "CNY" ? 'selected' : null }} value="CNY">CNY - Chinese Yuan</option>
    <option {{ old('currency',  $product->currency) == "COP" ? 'selected' : null }} value="COP">COP - Colombian Peso</option>
    <option {{ old('currency',  $product->currency) == "KMF" ? 'selected' : null }} value="KMF">KMF - Comorian Franc</option>
    <option {{ old('currency',  $product->currency) == "CDF" ? 'selected' : null }} value="CDF">CDF - Congolese Franc</option>
    <option {{ old('currency',  $product->currency) == "CRC" ? 'selected' : null }} value="CRC">CRC - Costa Rican ColÃ³n</option>
    <option {{ old('currency',  $product->currency) == "HRK" ? 'selected' : null }} value="HRK">HRK - Croatian Kuna</option>
    <option {{ old('currency',  $product->currency) == "CUC" ? 'selected' : null }} value="CUC">CUC - Cuban Convertible Peso</option>
    <option {{ old('currency',  $product->currency) == "CZK" ? 'selected' : null }} value="CZK">CZK - Czech Republic Koruna</option>
    <option {{ old('currency',  $product->currency) == "DKK" ? 'selected' : null }} value="DKK">DKK - Danish Krone</option>
    <option {{ old('currency',  $product->currency) == "DJF" ? 'selected' : null }} value="DJF">DJF - Djiboutian Franc</option>
    <option {{ old('currency',  $product->currency) == "DOP" ? 'selected' : null }} value="DOP">DOP - Dominican Peso</option>
    <option {{ old('currency',  $product->currency) == "XCD" ? 'selected' : null }} value="XCD">XCD - East Caribbean Dollar</option>
    <option {{ old('currency',  $product->currency) == "EGP" ? 'selected' : null }} value="EGP">EGP - Egyptian Pound</option>
    <option {{ old('currency',  $product->currency) == "ERN" ? 'selected' : null }} value="ERN">ERN - Eritrean Nakfa</option>
    <option {{ old('currency',  $product->currency) == "EEK" ? 'selected' : null }} value="EEK">EEK - Estonian Kroon</option>
    <option {{ old('currency',  $product->currency) == "ETB" ? 'selected' : null }} value="ETB">ETB - Ethiopian Birr</option>
    <option {{ old('currency',  $product->currency) == "EUR" ? 'selected' : null }} value="EUR">EUR - Euro</option>
    <option {{ old('currency',  $product->currency) == "FKP" ? 'selected' : null }} value="FKP">FKP - Falkland Islands Pound</option>
    <option {{ old('currency',  $product->currency) == "FJD" ? 'selected' : null }} value="FJD">FJD - Fijian Dollar</option>
    <option {{ old('currency',  $product->currency) == "GMD" ? 'selected' : null }} value="GMD">GMD - Gambian Dalasi</option>
    <option {{ old('currency',  $product->currency) == "GEL" ? 'selected' : null }} value="GEL">GEL - Georgian Lari</option>
    <option {{ old('currency',  $product->currency) == "DEM" ? 'selected' : null }} value="DEM">DEM - German Mark</option>
    <option {{ old('currency',  $product->currency) == "GHS" ? 'selected' : null }} value="GHS">GHS - Ghanaian Cedi</option>
    <option {{ old('currency',  $product->currency) == "GIP" ? 'selected' : null }} value="GIP">GIP - Gibraltar Pound</option>
    <option {{ old('currency',  $product->currency) == "GRD" ? 'selected' : null }} value="GRD">GRD - Greek Drachma</option>
    <option {{ old('currency',  $product->currency) == "GTQ" ? 'selected' : null }} value="GTQ">GTQ - Guatemalan Quetzal</option>
    <option {{ old('currency',  $product->currency) == "GNF" ? 'selected' : null }} value="GNF">GNF - Guinean Franc</option>
    <option {{ old('currency',  $product->currency) == "GYD" ? 'selected' : null }} value="GYD">GYD - Guyanaese Dollar</option>
    <option {{ old('currency',  $product->currency) == "HTG" ? 'selected' : null }} value="HTG">HTG - Haitian Gourde</option>
    <option {{ old('currency',  $product->currency) == "HNL" ? 'selected' : null }} value="HNL">HNL - Honduran Lempira</option>
    <option {{ old('currency',  $product->currency) == "HKD" ? 'selected' : null }} value="HKD">HKD - Hong Kong Dollar</option>
    <option {{ old('currency',  $product->currency) == "HUF" ? 'selected' : null }} value="HUF">HUF - Hungarian Forint</option>
    <option {{ old('currency',  $product->currency) == "ISK" ? 'selected' : null }} value="ISK">ISK - Icelandic KrÃ³na</option>
    <option {{ old('currency',  $product->currency) == "INR" ? 'selected' : null }} value="INR">INR - Indian Rupee</option>
    <option {{ old('currency',  $product->currency) == "IDR" ? 'selected' : null }} value="IDR">IDR - Indonesian Rupiah</option>
    <option {{ old('currency',  $product->currency) == "IRR" ? 'selected' : null }} value="IRR">IRR - Iranian Rial</option>
    <option {{ old('currency',  $product->currency) == "IQD" ? 'selected' : null }} value="IQD">IQD - Iraqi Dinar</option>
    <option {{ old('currency',  $product->currency) == "ILS" ? 'selected' : null }} value="ILS">ILS - Israeli New Sheqel</option>
    <option {{ old('currency',  $product->currency) == "ITL" ? 'selected' : null }} value="ITL">ITL - Italian Lira</option>
    <option {{ old('currency',  $product->currency) == "JMD" ? 'selected' : null }} value="JMD">JMD - Jamaican Dollar</option>
    <option {{ old('currency',  $product->currency) == "JPY" ? 'selected' : null }} value="JPY">JPY - Japanese Yen</option>
    <option {{ old('currency',  $product->currency) == "JOD" ? 'selected' : null }} value="JOD">JOD - Jordanian Dinar</option>
    <option {{ old('currency',  $product->currency) == "KZT" ? 'selected' : null }} value="KZT">KZT - Kazakhstani Tenge</option>
    <option {{ old('currency',  $product->currency) == "KES" ? 'selected' : null }} value="KES">KES - Kenyan Shilling</option>
    <option {{ old('currency',  $product->currency) == "KWD" ? 'selected' : null }} value="KWD">KWD - Kuwaiti Dinar</option>
    <option {{ old('currency',  $product->currency) == "KGS" ? 'selected' : null }} value="KGS">KGS - Kyrgystani Som</option>
    <option {{ old('currency',  $product->currency) == "LAK" ? 'selected' : null }} value="LAK">LAK - Laotian Kip</option>
    <option {{ old('currency',  $product->currency) == "LVL" ? 'selected' : null }} value="LVL">LVL - Latvian Lats</option>
    <option {{ old('currency',  $product->currency) == "LBP" ? 'selected' : null }} value="LBP">LBP - Lebanese Pound</option>
    <option {{ old('currency',  $product->currency) == "LSL" ? 'selected' : null }} value="LSL">LSL - Lesotho Loti</option>
    <option {{ old('currency',  $product->currency) == "LRD" ? 'selected' : null }} value="LRD">LRD - Liberian Dollar</option>
    <option {{ old('currency',  $product->currency) == "LYD" ? 'selected' : null }} value="LYD">LYD - Libyan Dinar</option>
    <option {{ old('currency',  $product->currency) == "LTL" ? 'selected' : null }} value="LTL">LTL - Lithuanian Litas</option>
    <option {{ old('currency',  $product->currency) == "MOP" ? 'selected' : null }} value="MOP">MOP - Macanese Pataca</option>
    <option {{ old('currency',  $product->currency) == "MKD" ? 'selected' : null }} value="MKD">MKD - Macedonian Denar</option>
    <option {{ old('currency',  $product->currency) == "MGA" ? 'selected' : null }} value="MGA">MGA - Malagasy Ariary</option>
    <option {{ old('currency',  $product->currency) == "MWK" ? 'selected' : null }} value="MWK">MWK - Malawian Kwacha</option>
    <option {{ old('currency',  $product->currency) == "MYR" ? 'selected' : null }} value="MYR">MYR - Malaysian Ringgit</option>
    <option {{ old('currency',  $product->currency) == "MVR" ? 'selected' : null }} value="MVR">MVR - Maldivian Rufiyaa</option>
    <option {{ old('currency',  $product->currency) == "MRO" ? 'selected' : null }} value="MRO">MRO - Mauritanian Ouguiya</option>
    <option {{ old('currency',  $product->currency) == "MUR" ? 'selected' : null }} value="MUR">MUR - Mauritian Rupee</option>
    <option {{ old('currency',  $product->currency) == "MXN" ? 'selected' : null }} value="MXN">MXN - Mexican Peso</option>
    <option {{ old('currency',  $product->currency) == "MDL" ? 'selected' : null }} value="MDL">MDL - Moldovan Leu</option>
    <option {{ old('currency',  $product->currency) == "MNT" ? 'selected' : null }} value="MNT">MNT - Mongolian Tugrik</option>
    <option {{ old('currency',  $product->currency) == "MAD" ? 'selected' : null }} value="MAD">MAD - Moroccan Dirham</option>
    <option {{ old('currency',  $product->currency) == "MZM" ? 'selected' : null }} value="MZM">MZM - Mozambican Metical</option>
    <option {{ old('currency',  $product->currency) == "MMK" ? 'selected' : null }} value="MMK">MMK - Myanmar Kyat</option>
    <option {{ old('currency',  $product->currency) == "NAD" ? 'selected' : null }} value="NAD">NAD - Namibian Dollar</option>
    <option {{ old('currency',  $product->currency) == "NPR" ? 'selected' : null }} value="NPR">NPR - Nepalese Rupee</option>
    <option {{ old('currency',  $product->currency) == "ANG" ? 'selected' : null }} value="ANG">ANG - Netherlands Antillean Guilder</option>
    <option {{ old('currency',  $product->currency) == "TWD" ? 'selected' : null }} value="TWD">TWD - New Taiwan Dollar</option>
    <option {{ old('currency',  $product->currency) == "NZD" ? 'selected' : null }} value="NZD">NZD - New Zealand Dollar</option>
    <option {{ old('currency',  $product->currency) == "NIO" ? 'selected' : null }} value="NIO">NIO - Nicaraguan CÃ³rdoba</option>
    <option {{ old('currency',  $product->currency) == "NGN" ? 'selected' : null }} value="NGN">NGN - Nigerian Naira</option>
    <option {{ old('currency',  $product->currency) == "KPW" ? 'selected' : null }} value="KPW">KPW - North Korean Won</option>
    <option {{ old('currency',  $product->currency) == "NOK" ? 'selected' : null }} value="NOK">NOK - Norwegian Krone</option>
    <option {{ old('currency',  $product->currency) == "OMR" ? 'selected' : null }} value="OMR">OMR - Omani Rial</option>
    <option {{ old('currency',  $product->currency) == "PKR" ? 'selected' : null }} value="PKR">PKR - Pakistani Rupee</option>
    <option {{ old('currency',  $product->currency) == "PAB" ? 'selected' : null }} value="PAB">PAB - Panamanian Balboa</option>
    <option {{ old('currency',  $product->currency) == "PGK" ? 'selected' : null }} value="PGK">PGK - Papua New Guinean Kina</option>
    <option {{ old('currency',  $product->currency) == "PYG" ? 'selected' : null }} value="PYG">PYG - Paraguayan Guarani</option>
    <option {{ old('currency',  $product->currency) == "PEN" ? 'selected' : null }} value="PEN">PEN - Peruvian Nuevo Sol</option>
    <option {{ old('currency',  $product->currency) == "PHP" ? 'selected' : null }} value="PHP">PHP - Philippine Peso</option>
    <option {{ old('currency',  $product->currency) == "PLN" ? 'selected' : null }} value="PLN">PLN - Polish Zloty</option>
    <option {{ old('currency',  $product->currency) == "QAR" ? 'selected' : null }} value="QAR">QAR - Qatari Rial</option>
    <option {{ old('currency',  $product->currency) == "RON" ? 'selected' : null }} value="RON">RON - Romanian Leu</option>
    <option {{ old('currency',  $product->currency) == "RUB" ? 'selected' : null }} value="RUB">RUB - Russian Ruble</option>
    <option {{ old('currency',  $product->currency) == "RWF" ? 'selected' : null }} value="RWF">RWF - Rwandan Franc</option>
    <option {{ old('currency',  $product->currency) == "SVC" ? 'selected' : null }} value="SVC">SVC - Salvadoran ColÃ³n</option>
    <option {{ old('currency',  $product->currency) == "WST" ? 'selected' : null }} value="WST">WST - Samoan Tala</option>
    <option {{ old('currency',  $product->currency) == "SAR" ? 'selected' : null }} value="SAR">SAR - Saudi Riyal</option>
    <option {{ old('currency',  $product->currency) == "RSD" ? 'selected' : null }} value="RSD">RSD - Serbian Dinar</option>
    <option {{ old('currency',  $product->currency) == "SCR" ? 'selected' : null }} value="SCR">SCR - Seychellois Rupee</option>
    <option {{ old('currency',  $product->currency) == "SLL" ? 'selected' : null }} value="SLL">SLL - Sierra Leonean Leone</option>
    <option {{ old('currency',  $product->currency) == "SGD" ? 'selected' : null }} value="SGD">SGD - Singapore Dollar</option>
    <option {{ old('currency',  $product->currency) == "SKK" ? 'selected' : null }} value="SKK">SKK - Slovak Koruna</option>
    <option {{ old('currency',  $product->currency) == "SBD" ? 'selected' : null }} value="SBD">SBD - Solomon Islands Dollar</option>
    <option {{ old('currency',  $product->currency) == "SOS" ? 'selected' : null }} value="SOS">SOS - Somali Shilling</option>
    <option {{ old('currency',  $product->currency) == "ZAR" ? 'selected' : null }} value="ZAR">ZAR - South African Rand</option>
    <option {{ old('currency',  $product->currency) == "KRW" ? 'selected' : null }} value="KRW">KRW - South Korean Won</option>
    <option {{ old('currency',  $product->currency) == "XDR" ? 'selected' : null }} value="XDR">XDR - Special Drawing Rights</option>
    <option {{ old('currency',  $product->currency) == "LKR" ? 'selected' : null }} value="LKR">LKR - Sri Lankan Rupee</option>
    <option {{ old('currency',  $product->currency) == "SHP" ? 'selected' : null }} value="SHP">SHP - St. Helena Pound</option>
    <option {{ old('currency',  $product->currency) == "SDG" ? 'selected' : null }} value="SDG">SDG - Sudanese Pound</option>
    <option {{ old('currency',  $product->currency) == "SRD" ? 'selected' : null }} value="SRD">SRD - Surinamese Dollar</option>
    <option {{ old('currency',  $product->currency) == "SZL" ? 'selected' : null }} value="SZL">SZL - Swazi Lilangeni</option>
    <option {{ old('currency',  $product->currency) == "SEK" ? 'selected' : null }} value="SEK">SEK - Swedish Krona</option>
    <option {{ old('currency',  $product->currency) == "CHF" ? 'selected' : null }} value="CHF">CHF - Swiss Franc</option>
    <option {{ old('currency',  $product->currency) == "SYP" ? 'selected' : null }} value="SYP">SYP - Syrian Pound</option>
    <option {{ old('currency',  $product->currency) == "STD" ? 'selected' : null }} value="STD">STD - São Tomé and Príncipe Dobra</option>
    <option {{ old('currency',  $product->currency) == "TJS" ? 'selected' : null }} value="TJS">TJS - Tajikistani Somoni</option>
    <option {{ old('currency',  $product->currency) == "TZS" ? 'selected' : null }} value="TZS">TZS - Tanzanian Shilling</option>
    <option {{ old('currency',  $product->currency) == "THB" ? 'selected' : null }} value="THB">THB - Thai Baht</option>
    <option {{ old('currency',  $product->currency) == "TOP" ? 'selected' : null }} value="TOP">TOP - Tongan pa'anga</option>
    <option {{ old('currency',  $product->currency) == "TTD" ? 'selected' : null }} value="TTD">TTD - Trinidad & Tobago Dollar</option>
    <option {{ old('currency',  $product->currency) == "TND" ? 'selected' : null }} value="TND">TND - Tunisian Dinar</option>
    <option {{ old('currency',  $product->currency) == "TRY" ? 'selected' : null }} value="TRY">TRY - Turkish Lira</option>
    <option {{ old('currency',  $product->currency) == "TMT" ? 'selected' : null }} value="TMT">TMT - Turkmenistani Manat</option>
    <option {{ old('currency',  $product->currency) == "UGX" ? 'selected' : null }} value="UGX">UGX - Ugandan Shilling</option>
    <option {{ old('currency',  $product->currency) == "UAH" ? 'selected' : null }} value="UAH">UAH - Ukrainian Hryvnia</option>
    <option {{ old('currency',  $product->currency) == "AED" ? 'selected' : null }} value="AED">AED - United Arab Emirates Dirham</option>
    <option {{ old('currency',  $product->currency) == "UYU" ? 'selected' : null }} value="UYU">UYU - Uruguayan Peso</option>
    <option {{ old('currency',  $product->currency) == "USD" ? 'selected' : null }} value="USD">USD - US Dollar</option>
    <option {{ old('currency',  $product->currency) == "UZS" ? 'selected' : null }} value="UZS">UZS - Uzbekistan Som</option>
    <option {{ old('currency',  $product->currency) == "VUV" ? 'selected' : null }} value="VUV">VUV - Vanuatu Vatu</option>
    <option {{ old('currency',  $product->currency) == "VEF" ? 'selected' : null }} value="VEF">VEF - Venezuelan BolÃ­var</option>
    <option {{ old('currency',  $product->currency) == "VND" ? 'selected' : null }} value="VND">VND - Vietnamese Dong</option>
    <option {{ old('currency',  $product->currency) == "YER" ? 'selected' : null }} value="YER">YER - Yemeni Rial</option>
    <option {{ old('currency',  $product->currency) == "ZMK" ? 'selected' : null }} value="ZMK">ZMK - Zambian Kwacha</option>
</select>
