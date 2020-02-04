(function($) {
		/**
				 * (c) http://stackoverflow.com/questions/2655308/jquery-version-compatibility-detection/3113707#3113707
				 * Used for version test cases.
				 * 
				 * @param {string} left A string containing the version that will become
				 *        the left hand operand.
				 * @param {string} oper The comparison operator to test against. By
				 *        default, the "==" operator will be used.
				 * @param {string} right A string containing the version that will
				 *        become the right hand operand. By default, the current jQuery
				 *        version will be used.
				 *        
				 * @return {boolean} Returns the evaluation of the expression, either
				 *         true or false.
				 *
				 *
				 *	$.isVersion("1.4.2"); // returns true, if $().jquery == "1.4.2"
				 *	$.isVersion("1.3.2", ">"); // returns true if $().jquery > "1.3.2"
				 *	$.isVersion("1.3", ">", "1.2.6"); // returns true
				 *	$.isVersion("1.3.2", "<", "1.3.1"); // returns false
				 *	$.isVersion("1.4.0", ">=", "1.3.2"); // returns true
				 *	$.isVersion("1.4.1", "<=", "1.4.1"); // returns true
				 *         
				 */
				 $.isVersion = function(left, oper, right) {
				 	if (left) {
				 		var pre = /pre/i,
				 		replace = /[^\d]+/g,
				 		oper = oper || "==",
				 		right = right || $().jquery,
				 		l = left.replace(replace, ""),
				 		r = right.replace(replace, ""),
				 		l_len = l.length, r_len = r.length,
				 		l_pre = pre.test(left), r_pre = pre.test(right);

				 		l = (r_len > l_len ? parseInt(l) * ((r_len - l_len) * 10) : parseInt(l));
				 		r = (l_len > r_len ? parseInt(r) * ((l_len - r_len) * 10) : parseInt(r));

				 		switch(oper) {
				 			case "==": {
				 				return (true === (l == r && (l_pre == r_pre)));
				 			}
				 			case ">=": {
				 				return (true === (l >= r && (!l_pre || l_pre == r_pre)));
				 			}
				 			case "<=": {
				 				return (true === (l <= r && (!r_pre || r_pre == l_pre)));
				 			}
				 			case ">": {
				 				return (true === (l > r || (l == r && r_pre)));
				 			}
				 			case "<": {
				 				return (true === (l < r || (l == r && l_pre)));
				 			}
				 		}
				 	}

				 	return false;
				 }
				})(jQuery);

				function notify(json, globalTtl, globalRegion)
				{
					var now = new Date();
					now = now.getTime();
					for (key in json)
					{

						if ( key != "data" && key != "comeback" )
						{
							if (typeof globalRegion != "undefined" && globalRegion != null)
								var region = globalRegion;
							else if (json[key].region == null || json[key].region == "default")
								var region = "default";
							else
								var region = json[key].region;

							if (typeof globalTtl != "undefined" && globalTtl != null)
								var ttl = globalTtl*1000;
							else
								var ttl = json[key].ttl*1000;


							$(".notify."+region).prepend("<div data-ttl=\""+ttl+"\" class=\"notice "+json[key].type+"\">"+json[key].message+"</div>");
						}

						if ( key == "comeback" && json["comeback"] != null && json["comeback"] != "" )
							window.location = json["comeback"];
					}

					$(".notice",".notify").click(function(){ $(this).fadeOut(300); });

				}

				function notifyIsSuccess(json)
				{
					if (json != undefined && json[0] != undefined && !json[0].isError)
						return true;
					else
						return false;
				}

				function notifyError(message, ttl, region)
				{
					var json = [{
						"isError" : 1,
						"type" : "error",
						"message" : message,
						"region"	: region,
						"ttl"		: ttl
					}];
					notify(json);
				}

				function notifySuccess(message, ttl, region)
				{
					var json = [{
						"isError" 	: 0,
						"type" 		: "success",
						"message" 	: message,
						"region"	: region,
						"ttl"		: ttl
					}];
					notify(json);
				}

				var notifyRegion;
				function notifySetRegion(region)
				{
					notifyRegion = region;
				}

				function close_old_notifies()
				{

					var now = new Date();
					now = now.getTime();
					if ($(".notify > div:visible").size())
					{
						$(".notify > div:visible").each(function()
						{
							if (!$(this).attr("data-time"))
							{
								$(this).attr("data-time",now);
							}

							var notice_time = $(this).attr("data-time");
							var notice_ttl = $(this).attr("data-ttl");

							if (notice_ttl != 0 && (now-notice_time) > notice_ttl )
								$(this).fadeOut(800);

						});
					}
				}

				$(document).ready(function()
				{
					if ($.isVersion("1.7", ">")) {
						$(".notice",".notify").live("click",function(){ $(this).fadeOut(300); });
					}
					else {
						$(".notify").on("click",".notice",function(){ $(this).fadeOut(300); });
					}

					setInterval("close_old_notifies()",500);

		/*$(".notice",".notify").hover(function()
		{
			$(this).css("opacity","1");
		},
		function()
		{
			$(this).css("opacity","0.5");
		});*/
	});