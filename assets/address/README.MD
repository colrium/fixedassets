jQuery Address Docs
The jQuery Address plugin doesn't add deep linking support automatically but provides the simplest possible API that developers can use to implement it on their own.
The most important concept of the plugin is that any navigation functionality should be invoked only when a change event is dispatched. This ensures that the proper code will be executed each time when the user clicks on the page, uses the back button of the browser or enters the site through a deep link.
Sample usage
A basic implementation in pure JavaScript can look like this:
view plainprint?
$.address.change(function(event) {  
    // do something depending on the event.value property, e.g.  
    // $('#content').load(event.value + '.xml');  
});  
$('a').click(function() {  
    $.address.value($(this).attr('href'));  
});  
The plugin also provides a jQuery function which can be directly used in the following way:
view plainprint?
$('a').address();  
The above snippet can be extended with an additional function that processes the link value:
view plainprint?
$('a').address(function() {  
    return $(this).attr('href').replace(/^#/, '');  
});  
By default the plugin automatically adds the appropriate JavaScript event handler to every link that has a rel attribute in the following format:
view plainprint?
<a href="/deep-link" rel="address:/deep-link">Deep link</a>  

Supported browsers
Internet Explorer 6.0+Mozilla Firefox 1.0+Safari 1.3+Opera 9.5+Chrome 1.0+Camino 1.0+
API reference
The jQuery Address plugin does not require initialization. Some of it's properties can be configured with query parameters using the following format: 
jquery.address-1.3.min.js?autoUpdate=1&crawling=1&history=1&tracker=trackFunction&state=/&strict=0&wrap=1
Events
$.address.bind(type, data, fn)	Returns: jQuery Address
Binds any supported event type to a function with support for an optional map of data.
$.address.change(fn)	Returns: jQuery Address
Binds a function to be executed whenever the address is changed. The function receives a single event object parameter that contains the following properties: value, path, pathNames, parameterNames, parameters and queryString.
$.address.init(fn)	Returns: jQuery Address
Binds a function to be executed once when the address is initiated. The function receives a single event object parameter that contains the following properties: value, path, pathNames, parameterNames, parameters and queryString.
$.address.internalChange(fn)	Returns: jQuery Address
Binds a function to be executed when the address is changed from inside the page that uses the plugin. The function receives a single event object parameter that contains the following properties: value, path, pathNames, parameterNames, parameters and queryString.
$.address.externalChange(fn)	Returns: jQuery Address
Binds a function to be executed when the address is changed from the browser usually when entering the page or using the back and forward buttons. The function receives a single event object parameter that contains the following properties: value, path, pathNames, parameterNames, parameters and queryString.
Methods
$.address.baseURL()	Returns: String
Provides the base address of the document.
$.address.autoUpdate()	Returns: Boolean
Provides the state of the auto update mode. Enabled by default.
$.address.autoUpdate(value)	Returns: jQuery Address
Enables or disables the auto update mode which can be turned off when multiple parameters values have to be changed at once.
$.address.crawlable()	Returns: Boolean
Provides the state of the crawling mode. Disables by default.
$.address.crawlable(value)	Returns: jQuery Address
Enables or disables the crawling mode which will automatically convert the values into a Google Ajax Crawling friendly format.
$.address.hash()	Returns: String
Provides the hash fragment part of the deep linking value.
$.address.hash(value)	Returns: jQuery Address
Sets the hash fragment part of the deep linking value.
$.address.history()	Returns: Boolean
Provides the state of the history mode setting. Enabled by default.
$.address.history(value)	Returns: jQuery Address
Enables or disables the history mode which generated entries in the browser history.
$.address.parameter(name)	Returns: String
Provides the value of a specific query parameter.
$.address.parameter(name, value, append)	Returns: jQuery Address
Sets a query parameter value. Appending is disabled by default but can be enabled for array values.
$.address.parameterNames()	Returns: Array
Provides a list of all the query parameter names.
$.address.path()	Returns: String
Provides the deep linking value without the query string and the hash fragment.
$.address.path(value)	Returns: jQuery Address
Sets the deep linking value without the query string and the hash fragment.
$.address.pathNames()	Returns: Array
Provides a list of all the folders in the deep linking path.
$.address.queryString()	Returns: String
Provides the query string part of the deep linking value.
$.address.queryString(value)	Returns: jQuery Address
Sets the query string part of the deep linking value.
$.address.state()	Returns: String
Provides the value used as a base path for the HTML5 state management.
$.address.state(value)	Returns: jQuery Address
Sets the base path of the website that is utilized in HTML5 state management.
$.address.strict()	Returns: Boolean
Provides the state of the strict mode setting. Enabled by default.
$.address.strict(value)	Returns: jQuery Address
Enables or disables the strict mode which automatically appends a slash in the beginning of the deep linking value.
$.address.title()	Returns: String
Provides the title of the HTML document.
$.address.title(value)	Returns: jQuery Address
Sets the title of the HTML document.
$.address.tracker()	Returns: String or Function
Provides the currently set page view tracking function.
$.address.tracker(value)	Returns: jQuery Address
Sets a function for page view tracking. Google Analytics tracking is automatically invoked if it exists in the page.
$.address.value()	Returns: String
Provides the current deep linking value.
$.address.value(value)	Returns: jQuery Address
Sets the current deep linking value.
$.address.update()	Returns: jQuery Address
Updates the value when auto updating is disabled.
$.address.wrap()	Returns: Boolean
Provides the state of the wrap mode. Disabled by default.
$.address.wrap(value)	Returns: jQuery Address
Enables or disables the wrap mode which generates a DIV wrapper around the page content and fixes any scroll issues caused by the use of hash fragments.
Functions
address(fn)	Returns: jQuery
Adds the plugin functionality to a DOM element and disables the default behavior. Designed primarily to support links and forms. Accepts an optional function parameter that allows custom processing of the deep link value.