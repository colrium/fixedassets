/*!
 * Bootstrap Colorpicker
 * http://mjolnic.github.io/bootstrap-colorpicker/
 *
 * Originally written by (c) 2012 Stefan Petre
 * Licensed under the Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * @todo Update DOCS
 */

(function(factory) {
		"use strict";
		if (typeof exports === 'object') {
			module.exports = factory(window.jQuery);
		} else if (typeof define === 'function' && define.amd) {
			define(['jquery'], factory);
		} else if (window.jQuery && !window.jQuery.fn.colorpicker) {
			factory(window.jQuery);
		}
	}
	(function($) {
		'use strict';

		// Color object
		var Color = function(val, customColors) {
			this.value = {
				h: 0,
				s: 0,
				b: 0,
				a: 1
			};
			this.origFormat = null; // original string format
			if (customColors) {
				$.extend(this.colors, customColors);
			}
			if (val) {
				if (val.toLowerCase !== undefined) {
					// cast to string
					val = val + '';
					this.setColor(val);
				} else if (val.h !== undefined) {
					this.value = val;
				}
			}
		};

		Color.prototype = {
			constructor: Color,
			// 256 predefined colors from the HTML Colors spec
			colors: {
						"red lighten-5": "#ffebee",
							"red lighten-4": "#ffcdd2",
							"red lighten-3": "#ef9a9a",
							"red lighten-2": "#e57373",
							"red lighten-1": "#ef5350",
							"red": "#f44336",
							"red darken-1": "#e53935",
							"red darken-2": "#d32f2f",
							"red darken-3": "#c62828",
							"red darken-4": "#b71c1c",
							"red accent-1": "#ff8a80",
							"red accent-2": "#ff5252",
							"red accent-3": "#ff1744",
							"red accent-4": "#d50000",
							"pink lighten-5": "#fce4ec",
							"pink lighten-4": "#f8bbd0",
							"pink lighten-3": "#f48fb1",
							"pink lighten-2": "#f06292",
							"pink lighten-1": "#ec407a",
							"pink": "#e91e63",
							"pink darken-1": "#d81b60",
							"pink darken-2": "#c2185b",
							"pink darken-3": "#ad1457",
							"pink darken-4": "#880e4f",
							"pink accent-1": "#ff80ab",
							"pink accent-2": "#ff4081",
							"pink accent-3": "#f50057",
							"pink accent-4": "#c51162",
							"purple lighten-5": "#f3e5f5",
							"purple lighten-4": "#e1bee7",
							"purple lighten-3": "#ce93d8",
							"purple lighten-2": "#ba68c8",
							"purple lighten-1": "#ab47bc",
							"purple": "#9c27b0",
							"purple darken-1": "#8e24aa",
							"purple darken-2": "#7b1fa2",
							"purple darken-3": "#6a1b9a",
							"purple darken-4": "#4a148c",
							"purple accent-1": "#ea80fc",
							"purple accent-2": "#e040fb",
							"purple accent-3": "#d500f9",
							"purple accent-4": "#aa00ff",
							"deep-purple lighten-5": "#ede7f6",
							"deep-purple lighten-4": "#d1c4e9",
							"deep-purple lighten-3": "#b39ddb",
							"deep-purple lighten-2": "#9575cd",
							"deep-purple lighten-1": "#7e57c2",
							"deep-purple": "#673ab7",
							"deep-purple darken-1": "#5e35b1",
							"deep-purple darken-2": "#512da8",
							"deep-purple darken-3": "#4527a0",
							"deep-purple darken-4": "#311b92",
							"deep-purple accent-1": "#b388ff",
							"deep-purple accent-2": "#7c4dff",
							"deep-purple accent-3": "#651fff",
							"deep-purple accent-4": "#6200ea",
							"indigo lighten-5": "#e8eaf6",
							"indigo lighten-4": "#c5cae9",
							"indigo lighten-3": "#9fa8da",
							"indigo lighten-2": "#7986cb",
							"indigo lighten-1": "#5c6bc0",
							"indigo": "#3f51b5",
							"indigo darken-1": "#3949ab",
							"indigo darken-2": "#303f9f",
							"indigo darken-3": "#283593",
							"indigo darken-4": "#1a237e",
							"indigo accent-1": "#8c9eff",
							"indigo accent-2": "#536dfe",
							"indigo accent-3": "#3d5afe",
							"indigo accent-4": "#304ffe",
							"blue lighten-5": "#e3f2fd",
							"blue lighten-4": "#bbdefb",
							"blue lighten-3": "#90caf9",
							"blue lighten-2": "#64b5f6",
							"blue lighten-1": "#42a5f5",
							"blue": "#2196f3",
							"blue darken-1": "#1e88e5",
							"blue darken-2": "#1976d2",
							"blue darken-3": "#1565c0",
							"blue darken-4": "#0d47a1",
							"blue accent-1": "#82b1ff",
							"blue accent-2": "#448aff",
							"blue accent-3": "#2979ff",
							"blue accent-4": "#2962ff",
							"light-blue lighten-5": "#e1f5fe",
							"light-blue lighten-4": "#b3e5fc",
							"light-blue lighten-3": "#81d4fa",
							"light-blue lighten-2": "#4fc3f7",
							"light-blue lighten-1": "#29b6f6",
							"light-blue": "#03a9f4",
							"light-blue darken-1": "#039be5",
							"light-blue darken-2": "#0288d1",
							"light-blue darken-3": "#0277bd",
							"light-blue darken-4": "#01579b",
							"light-blue accent-1": "#80d8ff",
							"light-blue accent-2": "#40c4ff",
							"light-blue accent-3": "#00b0ff",
							"light-blue accent-4": "#0091ea",
							"cyan lighten-5": "#e0f7fa",
							"cyan lighten-4": "#b2ebf2",
							"cyan lighten-3": "#80deea",
							"cyan lighten-2": "#4dd0e1",
							"cyan lighten-1": "#26c6da",
							"cyan": "#00bcd4",
							"cyan darken-1": "#00acc1",
							"cyan darken-2": "#0097a7",
							"cyan darken-3": "#00838f",
							"cyan darken-4": "#006064",
							"cyan accent-1": "#84ffff",
							"cyan accent-2": "#18ffff",
							"cyan accent-3": "#00e5ff",
							"cyan accent-4": "#00b8d4",
							"teal lighten-5": "#e0f2f1",
							"teal lighten-4": "#b2dfdb",
							"teal lighten-3": "#80cbc4",
							"teal lighten-2": "#4db6ac",
							"teal lighten-1": "#26a69a",
							"teal": "#009688",
							"teal darken-1": "#00897b",
							"teal darken-2": "#00796b",
							"teal darken-3": "#00695c",
							"teal darken-4": "#004d40",
							"teal accent-1": "#a7ffeb",
							"teal accent-2": "#64ffda",
							"teal accent-3": "#1de9b6",
							"teal accent-4": "#00bfa5",
							"green lighten-5": "#e8f5e9",
							"green lighten-4": "#c8e6c9",
							"green lighten-3": "#a5d6a7",
							"green lighten-2": "#81c784",
							"green lighten-1": "#66bb6a",
							"green": "#4caf50",
							"green darken-1": "#43a047",
							"green darken-2": "#388e3c",
							"green darken-3": "#2e7d32",
							"green darken-4": "#1b5e20",
							"green accent-1": "#b9f6ca",
							"green accent-2": "#69f0ae",
							"green accent-3": "#00e676",
							"green accent-4": "#00c853",
							"light-green lighten-5": "#f1f8e9",
							"light-green lighten-4": "#dcedc8",
							"light-green lighten-3": "#c5e1a5",
							"light-green lighten-2": "#aed581",
							"light-green lighten-1": "#9ccc65",
							"light-green": "#8bc34a",
							"light-green darken-1": "#7cb342",
							"light-green darken-2": "#689f38",
							"light-green darken-3": "#558b2f",
							"light-green darken-4": "#33691e",
							"light-green accent-1": "#ccff90",
							"light-green accent-2": "#b2ff59",
							"light-green accent-3": "#76ff03",
							"light-green accent-4": "#64dd17",
							"lime lighten-5": "#f9fbe7",
							"lime lighten-4": "#f0f4c3",
							"lime lighten-3": "#e6ee9c",
							"lime lighten-2": "#dce775",
							"lime lighten-1": "#d4e157",
							"lime": "#cddc39",
							"lime darken-1": "#c0ca33",
							"lime darken-2": "#afb42b",
							"lime darken-3": "#9e9d24",
							"lime darken-4": "#827717",
							"lime accent-1": "#f4ff81",
							"lime accent-2": "#eeff41",
							"lime accent-3": "#c6ff00",
							"lime accent-4": "#aeea00",
							"yellow lighten-5": "#fffde7",
							"yellow lighten-4": "#fff9c4",
							"yellow lighten-3": "#fff59d",
							"yellow lighten-2": "#fff176",
							"yellow lighten-1": "#ffee58",
							"yellow": "#ffeb3b",
							"yellow darken-1": "#fdd835",
							"yellow darken-2": "#fbc02d",
							"yellow darken-3": "#f9a825",
							"yellow darken-4": "#f57f17",
							"yellow accent-1": "#ffff8d",
							"yellow accent-2": "#ffff00",
							"yellow accent-3": "#ffea00",
							"yellow accent-4": "#ffd600",
							"amber lighten-5": "#fff8e1",
							"amber lighten-4": "#ffecb3",
							"amber lighten-3": "#ffe082",
							"amber lighten-2": "#ffd54f",
							"amber lighten-1": "#ffca28",
							"amber": "#ffc107",
							"amber darken-1": "#ffb300",
							"amber darken-2": "#ffa000",
							"amber darken-3": "#ff8f00",
							"amber darken-4": "#ff6f00",
							"amber accent-1": "#ffe57f",
							"amber accent-2": "#ffd740",
							"amber accent-3": "#ffc400",
							"amber accent-4": "#ffab00",
							"orange lighten-5": "#fff3e0",
							"orange lighten-4": "#ffe0b2",
							"orange lighten-3": "#ffcc80",
							"orange lighten-2": "#ffb74d",
							"orange lighten-1": "#ffa726",
							"orange": "#ff9800",
							"orange darken-1": "#fb8c00",
							"orange darken-2": "#f57c00",
							"orange darken-3": "#ef6c00",
							"orange darken-4": "#e65100",
							"orange accent-1": "#ffd180",
							"orange accent-2": "#ffab40",
							"orange accent-3": "#ff9100",
							"orange accent-4": "#ff6d00",
							"deep-orange lighten-5": "#fbe9e7",
							"deep-orange lighten-4": "#ffccbc",
							"deep-orange lighten-3": "#ffab91",
							"deep-orange lighten-2": "#ff8a65",
							"deep-orange lighten-1": "#ff7043",
							"deep-orange": "#ff5722",
							"deep-orange darken-1": "#f4511e",
							"deep-orange darken-2": "#e64a19",
							"deep-orange darken-3": "#d84315",
							"deep-orange darken-4": "#bf360c",
							"deep-orange accent-1": "#ff9e80",
							"deep-orange accent-2": "#ff6e40",
							"deep-orange accent-3": "#ff3d00",
							"deep-orange accent-4": "#dd2c00",
							"brown lighten-5": "#efebe9",
							"brown lighten-4": "#d7ccc8",
							"brown lighten-3": "#bcaaa4",
							"brown lighten-2": "#a1887f",
							"brown lighten-1": "#8d6e63",
							"brown": "#795548",
							"brown darken-1": "#6d4c41",
							"brown darken-2": "#5d4037",
							"brown darken-3": "#4e342e",
							"brown darken-4": "#3e2723",
							"grey lighten-5": "#fafafa",
							"grey lighten-4": "#f5f5f5",
							"grey lighten-3": "#eeeeee",
							"grey lighten-2": "#e0e0e0",
							"grey lighten-1": "#bdbdbd",
							"grey": "#9e9e9e",
							"grey darken-1": "#757575",
							"grey darken-2": "#616161",
							"grey darken-3": "#424242",
							"grey darken-4": "#212121",
							"blue-grey lighten-5": "#eceff1",
							"blue-grey lighten-4": "#cfd8dc",
							"blue-grey lighten-3": "#b0bec5",
							"blue-grey lighten-2": "#90a4ae",
							"blue-grey lighten-1": "#78909c",
							"blue-grey": "#607d8b",
							"blue-grey darken-1": "#546e7a",
							"blue-grey darken-2": "#455a64",
							"blue-grey darken-3": "#37474f",
							"blue-grey darken-4": "#263238",
							"black": "#000000",
							"white": "#ffffff"
			},
			_sanitizeNumber: function(val) {
				if (typeof val === 'number') {
					return val;
				}
				if (isNaN(val) || (val === null) || (val === '') || (val === undefined)) {
					return 1;
				}
				if (val.toLowerCase !== undefined) {
					return parseFloat(val);
				}
				return 1;
			},
			isTransparent: function(strVal) {
				if (!strVal) {
					return false;
				}
				strVal = strVal.toLowerCase().trim();
				return (strVal === 'transparent') || (strVal.match(/#?00000000/)) || (strVal.match(/(rgba|hsla)\(0,0,0,0?\.?0\)/));
			},
			rgbaIsTransparent: function(rgba) {
				return ((rgba.r === 0) && (rgba.g === 0) && (rgba.b === 0) && (rgba.a === 0));
			},
			//parse a string to HSB
			setColor: function(strVal) {
				strVal = strVal.toLowerCase().trim();
				if (strVal) {
					if (this.isTransparent(strVal)) {
						this.value = {
							h: 0,
							s: 0,
							b: 0,
							a: 0
						};
					} else {
						this.value = this.stringToHSB(strVal) || {
							h: 0,
							s: 0,
							b: 0,
							a: 1
						}; // if parser fails, defaults to black
					}
				}
			},
			stringToHSB: function(strVal) {
				strVal = strVal.toLowerCase();
				var alias;
				if (typeof this.colors[strVal] !== 'undefined') {
					strVal = this.colors[strVal];
					alias = 'alias';
				}
				var that = this,
					result = false;
				$.each(this.stringParsers, function(i, parser) {
					var match = parser.re.exec(strVal),
						values = match && parser.parse.apply(that, [match]),
						format = alias || parser.format || 'rgba';
					if (values) {
						if (format.match(/hsla?/)) {
							result = that.RGBtoHSB.apply(that, that.HSLtoRGB.apply(that, values));
						} else {
							result = that.RGBtoHSB.apply(that, values);
						}
						that.origFormat = format;
						return false;
					}
					return true;
				});
				return result;
			},
			setHue: function(h) {
				this.value.h = 1 - h;
			},
			setSaturation: function(s) {
				this.value.s = s;
			},
			setBrightness: function(b) {
				this.value.b = 1 - b;
			},
			setAlpha: function(a) {
				this.value.a = parseInt((1 - a) * 100, 10) / 100;
			},
			toRGB: function(h, s, b, a) {
				if (!h) {
					h = this.value.h;
					s = this.value.s;
					b = this.value.b;
				}
				h *= 360;
				var R, G, B, X, C;
				h = (h % 360) / 60;
				C = b * s;
				X = C * (1 - Math.abs(h % 2 - 1));
				R = G = B = b - C;

				h = ~~h;
				R += [C, X, 0, 0, X, C][h];
				G += [X, C, C, X, 0, 0][h];
				B += [0, 0, X, C, C, X][h];
				return {
					r: Math.round(R * 255),
					g: Math.round(G * 255),
					b: Math.round(B * 255),
					a: a || this.value.a
				};
			},
			toHex: function(h, s, b, a) {
				var rgb = this.toRGB(h, s, b, a);
				if (this.rgbaIsTransparent(rgb)) {
					return 'transparent';
				}
				return '#' + ((1 << 24) | (parseInt(rgb.r) << 16) | (parseInt(rgb.g) << 8) | parseInt(rgb.b)).toString(16).substr(1);
			},
			toHSL: function(h, s, b, a) {
				h = h || this.value.h;
				s = s || this.value.s;
				b = b || this.value.b;
				a = a || this.value.a;

				var H = h,
					L = (2 - s) * b,
					S = s * b;
				if (L > 0 && L <= 1) {
					S /= L;
				} else {
					S /= 2 - L;
				}
				L /= 2;
				if (S > 1) {
					S = 1;
				}
				return {
					h: isNaN(H) ? 0 : H,
					s: isNaN(S) ? 0 : S,
					l: isNaN(L) ? 0 : L,
					a: isNaN(a) ? 0 : a
				};
			},
			toAlias: function(r, g, b, a) {
				var rgb = this.toHex(r, g, b, a);
				for (var alias in this.colors) {
					if (this.colors[alias] === rgb) {
						return alias;
					}
				}
				return false;
			},
			RGBtoHSB: function(r, g, b, a) {
				r /= 255;
				g /= 255;
				b /= 255;

				var H, S, V, C;
				V = Math.max(r, g, b);
				C = V - Math.min(r, g, b);
				H = (C === 0 ? null :
					V === r ? (g - b) / C :
					V === g ? (b - r) / C + 2 :
					(r - g) / C + 4
				);
				H = ((H + 360) % 6) * 60 / 360;
				S = C === 0 ? 0 : C / V;
				return {
					h: this._sanitizeNumber(H),
					s: S,
					b: V,
					a: this._sanitizeNumber(a)
				};
			},
			HueToRGB: function(p, q, h) {
				if (h < 0) {
					h += 1;
				} else if (h > 1) {
					h -= 1;
				}
				if ((h * 6) < 1) {
					return p + (q - p) * h * 6;
				} else if ((h * 2) < 1) {
					return q;
				} else if ((h * 3) < 2) {
					return p + (q - p) * ((2 / 3) - h) * 6;
				} else {
					return p;
				}
			},
			HSLtoRGB: function(h, s, l, a) {
				if (s < 0) {
					s = 0;
				}
				var q;
				if (l <= 0.5) {
					q = l * (1 + s);
				} else {
					q = l + s - (l * s);
				}

				var p = 2 * l - q;

				var tr = h + (1 / 3);
				var tg = h;
				var tb = h - (1 / 3);

				var r = Math.round(this.HueToRGB(p, q, tr) * 255);
				var g = Math.round(this.HueToRGB(p, q, tg) * 255);
				var b = Math.round(this.HueToRGB(p, q, tb) * 255);
				return [r, g, b, this._sanitizeNumber(a)];
			},
			toString: function(format) {
				format = format || 'rgba';
				var c = false;
				switch (format) {
					case 'rgb':
						{
							c = this.toRGB();
							if (this.rgbaIsTransparent(c)) {
								return 'transparent';
							}
							return 'rgb(' + c.r + ',' + c.g + ',' + c.b + ')';
						}
						break;
					case 'rgba':
						{
							c = this.toRGB();
							return 'rgba(' + c.r + ',' + c.g + ',' + c.b + ',' + c.a + ')';
						}
						break;
					case 'hsl':
						{
							c = this.toHSL();
							return 'hsl(' + Math.round(c.h * 360) + ',' + Math.round(c.s * 100) + '%,' + Math.round(c.l * 100) + '%)';
						}
						break;
					case 'hsla':
						{
							c = this.toHSL();
							return 'hsla(' + Math.round(c.h * 360) + ',' + Math.round(c.s * 100) + '%,' + Math.round(c.l * 100) + '%,' + c.a + ')';
						}
						break;
					case 'hex':
						{
							return this.toHex();
						}
						break;
					case 'alias':
						return this.toAlias() || this.toHex();
					default:
						{
							return c;
						}
						break;
				}
			},
			// a set of RE's that can match strings and generate color tuples.
			// from John Resig color plugin
			// https://github.com/jquery/jquery-color/
			stringParsers: [{
				re: /rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*?\)/,
				format: 'rgb',
				parse: function(execResult) {
					return [
						execResult[1],
						execResult[2],
						execResult[3],
						1
					];
				}
			}, {
				re: /rgb\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*?\)/,
				format: 'rgb',
				parse: function(execResult) {
					return [
						2.55 * execResult[1],
						2.55 * execResult[2],
						2.55 * execResult[3],
						1
					];
				}
			}, {
				re: /rgba\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
				format: 'rgba',
				parse: function(execResult) {
					return [
						execResult[1],
						execResult[2],
						execResult[3],
						execResult[4]
					];
				}
			}, {
				re: /rgba\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
				format: 'rgba',
				parse: function(execResult) {
					return [
						2.55 * execResult[1],
						2.55 * execResult[2],
						2.55 * execResult[3],
						execResult[4]
					];
				}
			}, {
				re: /hsl\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*?\)/,
				format: 'hsl',
				parse: function(execResult) {
					return [
						execResult[1] / 360,
						execResult[2] / 100,
						execResult[3] / 100,
						execResult[4]
					];
				}
			}, {
				re: /hsla\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
				format: 'hsla',
				parse: function(execResult) {
					return [
						execResult[1] / 360,
						execResult[2] / 100,
						execResult[3] / 100,
						execResult[4]
					];
				}
			}, {
				re: /#?([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,
				format: 'hex',
				parse: function(execResult) {
					return [
						parseInt(execResult[1], 16),
						parseInt(execResult[2], 16),
						parseInt(execResult[3], 16),
						1
					];
				}
			}, {
				re: /#?([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/,
				format: 'hex',
				parse: function(execResult) {
					return [
						parseInt(execResult[1] + execResult[1], 16),
						parseInt(execResult[2] + execResult[2], 16),
						parseInt(execResult[3] + execResult[3], 16),
						1
					];
				}
			}],
			colorNameToHex: function(name) {
				if (typeof this.colors[name.toLowerCase()] !== 'undefined') {
					return this.colors[name.toLowerCase()];
				}
				return false;
			}
		};


		var defaults = {
			horizontal: false, // horizontal mode layout ?
			inline: false, //forces to show the colorpicker as an inline element
			color: false, //forces a color
			format: false, //forces a format
			input: 'input', // children input selector
			container: false, // container selector
			component: '.add-on, .input-group-addon', // children component selector
			sliders: {
				saturation: {
					maxLeft: 100,
					maxTop: 100,
					callLeft: 'setSaturation',
					callTop: 'setBrightness'
				},
				hue: {
					maxLeft: 0,
					maxTop: 100,
					callLeft: false,
					callTop: 'setHue'
				},
				alpha: {
					maxLeft: 0,
					maxTop: 100,
					callLeft: false,
					callTop: 'setAlpha'
				}
			},
			slidersHorz: {
				saturation: {
					maxLeft: 100,
					maxTop: 100,
					callLeft: 'setSaturation',
					callTop: 'setBrightness'
				},
				hue: {
					maxLeft: 100,
					maxTop: 0,
					callLeft: 'setHue',
					callTop: false
				},
				alpha: {
					maxLeft: 100,
					maxTop: 0,
					callLeft: 'setAlpha',
					callTop: false
				}
			},
			template:
				'<div class="colorpicker colorpicker-dropdown">' +
					'<div class="colorpicker-saturation"><i><b></b></i></div>' +
					'<div class="colorpicker-hue"><i></i></div>' +
					'<div class="colorpicker-alpha"><i></i></div>' +
					'<div class="colorpicker-color"><div /></div>' +
					'<div class="colorpicker-selectors"></div>' +
			'</div>',
			align: 'left',
			customClass: null,
			colorSelectors: null,
			selectorsOnly : false,
			useDefaultColorClasses:true
		};

		var Colorpicker = function(element, options) {
			this.element = $(element).addClass('colorpicker-element');
			this.options = $.extend(true, {}, defaults, this.element.data(), options);
			this.component = this.options.component;
			this.component = (this.component !== false) ? this.element.find(this.component) : false;
			if (this.component && (this.component.length === 0)) {
				this.component = false;
			} else {
					
					if (this.component.is('input')) {
							var valcolor = this.component.val();
							var colorarr = new Color(valcolor, Color.prototype.colors);
							this.options.color = colorarr.value;
					}
					else{
						this.options.color = this.component.css('background-color');
					}
				
			}

			this.container = (this.options.container === true) ? this.element : this.options.container;
			this.container = (this.container !== false) ? $(this.container) : false;

			// Is the element an input? Should we search inside for any input?
			this.input = this.element.is('input') ? this.element : (this.options.input ?
				this.element.find(this.options.input) : false);
			if (this.input && (this.input.length === 0)) {
				this.input = false;
			}
			
			// Set HSB color
			this.color = new Color(this.options.color !== false ? this.options.color : this.getValue(), this.options.colorSelectors);
			if(this.options.selectorsOnly != false){
					this.format = this.options.format !== false ? this.options.format : this.color.origFormat;
			}
			else{
					this.format = this.options.format !== false ? this.options.format : this.color.origFormat;
			}
			

			// Setup picker
			this.picker = $(this.options.template);
			if (this.options.customClass) {
				this.picker.addClass(this.options.customClass);
			}
			if (this.options.inline) {
				this.picker.addClass('colorpicker-inline colorpicker-visible');
			} else {
				this.picker.addClass('colorpicker-hidden');
			}
			if (this.options.horizontal) {
				this.picker.addClass('colorpicker-horizontal');
			}

			if (this.format === 'rgba' || this.format === 'hsla' || this.options.format === false) {
				
					this.picker.addClass('colorpicker-with-alpha');
				
			}
			if (this.options.align === 'right') {
				this.picker.addClass('colorpicker-right');
			}
			if (this.options.inline === true) {
				this.picker.addClass('colorpicker-no-arrow');
			}
			if (this.options.useDefaultColorClasses === true) {
			 this.options.colorSelectors = Color.prototype.colors;
			}
			if (this.options.colorSelectors) {

				var colorpicker = this;
				$.each(this.options.colorSelectors, function(name, color) {
					var $btn = $('<i />').css('background-color', color).css('margin', '5px').data('class', name);
					$btn.click(function() {
						colorpicker.setValue($(this).css('background-color'));
					});
					colorpicker.picker.find('.colorpicker-selectors').append($btn);
				});
				this.picker.find('.colorpicker-selectors').show();
				if (this.options.selectorsOnly === true) {
					this.picker.find('.colorpicker-alpha').hide();
					this.picker.find('.colorpicker-hue').hide();
					this.picker.find('.colorpicker-saturation').hide();
				}

			}
			this.picker.on('mousedown.colorpicker touchstart.colorpicker', $.proxy(this.mousedown, this));
			this.picker.appendTo(this.container ? this.container : $('body'));

			// Bind events
			if (this.input !== false) {
				this.input.on({
					'keyup.colorpicker': $.proxy(this.keyup, this)
				});
				this.input.on({
					'change.colorpicker': $.proxy(this.change, this)
				});
				if (this.component === false) {
					this.element.on({
						'focus.colorpicker': $.proxy(this.show, this)
					});
				}
				if (this.options.inline === false) {
					this.element.on({
						'focusout.colorpicker': $.proxy(this.hide, this)
					});
				}
			}

			if (this.component !== false) {
				this.component.on({
					'click.colorpicker': $.proxy(this.show, this)
				});
			}

			if ((this.input === false) && (this.component === false)) {
				this.element.on({
					'click.colorpicker': $.proxy(this.show, this)
				});
			}

			// for HTML5 input[type='color']
			if ((this.input !== false) && (this.component !== false) && (this.input.attr('type') === 'color')) {

				this.input.on({
					'click.colorpicker': $.proxy(this.show, this),
					'focus.colorpicker': $.proxy(this.show, this)
				});
			}
			this.update(true);

			$($.proxy(function() {
				this.element.trigger('create');
			}, this));
		};

		Colorpicker.Color = Color;

		Colorpicker.prototype = {
			constructor: Colorpicker,
			destroy: function() {
				this.picker.remove();
				this.element.removeData('colorpicker').off('.colorpicker');
				if (this.input !== false) {
					this.input.off('.colorpicker');
				}
				if (this.component !== false) {
					this.component.off('.colorpicker');
				}
				this.element.removeClass('colorpicker-element');
				this.element.trigger({
					type: 'destroy'
				});
			},
			reposition: function() {
				if (this.options.inline !== false || this.options.container) {
					return false;
				}
				var type = this.container && this.container[0] !== document.body ? 'position' : 'offset';
				var element = this.component || this.element;
				var offset = element[type]();
				if (this.options.align === 'right') {
					offset.left -= this.picker.outerWidth() - element.outerWidth();
				}
				this.picker.css({
					top: offset.top + element.outerHeight(),
					left: offset.left
				});
			},
			show: function(e) {
				if (this.isDisabled()) {
					return false;
				}
				this.picker.addClass('colorpicker-visible').removeClass('colorpicker-hidden');
				this.reposition();
				$(window).on('resize.colorpicker', $.proxy(this.reposition, this));
				if (e && (!this.hasInput() || this.input.attr('type') === 'color')) {
					if (e.stopPropagation && e.preventDefault) {
						e.stopPropagation();
						e.preventDefault();
					}
				}
				if (this.options.inline === false) {
					$(window.document).on({
						'mousedown.colorpicker': $.proxy(this.hide, this)
					});
				}
				this.element.trigger({
					type: 'showPicker',
					color: this.color
				});
			},
			hide: function() {
				this.picker.addClass('colorpicker-hidden').removeClass('colorpicker-visible');
				$(window).off('resize.colorpicker', this.reposition);
				$(document).off({
					'mousedown.colorpicker': this.hide
				});
				this.update();
				this.element.trigger({
					type: 'hidePicker',
					color: this.color
				});
			},
			updateData: function(val) {
				val = val || this.color.toString(this.format);
				this.element.data('color', val);
				return val;
			},
			updateInput: function(val) {
				val = val || this.color.toString(this.format);
				if (this.input !== false) {
					if (this.options.colorSelectors) {
						var color = new Color(val, this.options.colorSelectors);
						var alias = color.toAlias();
						if (typeof this.options.colorSelectors[alias] !== 'undefined') {
							val = alias;
						}
					}
					this.input.prop('value', val);
				}
				return val;
			},
			updatePicker: function(val) {
				if (val !== undefined) {
					this.color = new Color(val, this.options.colorSelectors);
				}
				var sl = (this.options.horizontal === false) ? this.options.sliders : this.options.slidersHorz;
				var icns = this.picker.find('i');
				if (icns.length === 0) {
					return;
				}
				if (this.options.horizontal === false) {
					sl = this.options.sliders;
					icns.eq(1).css('top', sl.hue.maxTop * (1 - this.color.value.h)).end()
						.eq(2).css('top', sl.alpha.maxTop * (1 - this.color.value.a));
				} else {
					sl = this.options.slidersHorz;
					icns.eq(1).css('left', sl.hue.maxLeft * (1 - this.color.value.h)).end()
						.eq(2).css('left', sl.alpha.maxLeft * (1 - this.color.value.a));
				}
				icns.eq(0).css({
					'top': sl.saturation.maxTop - this.color.value.b * sl.saturation.maxTop,
					'left': this.color.value.s * sl.saturation.maxLeft
				});
				this.picker.find('.colorpicker-saturation').css('backgroundColor', this.color.toHex(this.color.value.h, 1, 1, 1));
				this.picker.find('.colorpicker-alpha').css('backgroundColor', this.color.toHex());
				this.picker.find('.colorpicker-color, .colorpicker-color div').css('backgroundColor', this.color.toString(this.format));
				return val;
			},
			updateComponent: function(val) {
				val = val || this.color.toString(this.format);
				if (this.component !== false) {
					var icn = this.component;
					if (icn.length > 0) {
						icn.css({
							'backgroundColor': val
						});
					} else {
						this.component.css({
							'backgroundColor': val
						});
					}
				}
				return val;
			},
			update: function(force) {
				var val;
				if ((this.getValue(false) !== false) || (force === true)) {
					// Update input/data only if the current value is not empty
					val = this.updateComponent();
					this.updateInput(val);
					this.updateData(val);
					this.updatePicker(); // only update picker if value is not empty
				}
				return val;

			},
			setValue: function(val) { // set color manually
				this.color = new Color(val, this.options.colorSelectors);
				this.update(true);
				this.element.trigger({
					type: 'changeColor',
					color: this.color,
					value: val
				});
			},
			getValue: function(defaultValue) {
				defaultValue = (defaultValue === undefined) ? '#000000' : defaultValue;
				var val;
				if (this.hasInput()) {
					val = this.input.val();
				} else {
					val = this.element.data('color');
				}
				if ((val === undefined) || (val === '') || (val === null)) {
					// if not defined or empty, return default
					val = defaultValue;
				}
				return val;
			},
			hasInput: function() {
				return (this.input !== false);
			},
			isDisabled: function() {
				if (this.hasInput()) {
					return (this.input.prop('disabled') === true);
				}
				return false;
			},
			disable: function() {
				if (this.hasInput()) {
					this.input.prop('disabled', true);
					this.element.trigger({
						type: 'disable',
						color: this.color,
						value: this.getValue()
					});
					return true;
				}
				return false;
			},
			enable: function() {
				if (this.hasInput()) {
					this.input.prop('disabled', false);
					this.element.trigger({
						type: 'enable',
						color: this.color,
						value: this.getValue()
					});
					return true;
				}
				return false;
			},
			currentSlider: null,
			mousePointer: {
				left: 0,
				top: 0
			},
			mousedown: function(e) {
				if (!e.pageX && !e.pageY && e.originalEvent) {
					e.pageX = e.originalEvent.touches[0].pageX;
					e.pageY = e.originalEvent.touches[0].pageY;
				}
				e.stopPropagation();
				e.preventDefault();

				var target = $(e.target);

				//detect the slider and set the limits and callbacks
				var zone = target.closest('div');
				var sl = this.options.horizontal ? this.options.slidersHorz : this.options.sliders;
				if (!zone.is('.colorpicker')) {
					if (zone.is('.colorpicker-saturation')) {
						this.currentSlider = $.extend({}, sl.saturation);
					} else if (zone.is('.colorpicker-hue')) {
						this.currentSlider = $.extend({}, sl.hue);
					} else if (zone.is('.colorpicker-alpha')) {
						this.currentSlider = $.extend({}, sl.alpha);
					} else {
						return false;
					}
					var offset = zone.offset();
					//reference to guide's style
					this.currentSlider.guide = zone.find('i')[0].style;
					this.currentSlider.left = e.pageX - offset.left;
					this.currentSlider.top = e.pageY - offset.top;
					this.mousePointer = {
						left: e.pageX,
						top: e.pageY
					};
					//trigger mousemove to move the guide to the current position
					$(document).on({
						'mousemove.colorpicker': $.proxy(this.mousemove, this),
						'touchmove.colorpicker': $.proxy(this.mousemove, this),
						'mouseup.colorpicker': $.proxy(this.mouseup, this),
						'touchend.colorpicker': $.proxy(this.mouseup, this)
					}).trigger('mousemove');
				}
				return false;
			},
			mousemove: function(e) {
				if (!e.pageX && !e.pageY && e.originalEvent) {
					e.pageX = e.originalEvent.touches[0].pageX;
					e.pageY = e.originalEvent.touches[0].pageY;
				}
				e.stopPropagation();
				e.preventDefault();
				var left = Math.max(
					0,
					Math.min(
						this.currentSlider.maxLeft,
						this.currentSlider.left + ((e.pageX || this.mousePointer.left) - this.mousePointer.left)
					)
				);
				var top = Math.max(
					0,
					Math.min(
						this.currentSlider.maxTop,
						this.currentSlider.top + ((e.pageY || this.mousePointer.top) - this.mousePointer.top)
					)
				);
				this.currentSlider.guide.left = left + 'px';
				this.currentSlider.guide.top = top + 'px';
				if (this.currentSlider.callLeft) {
					this.color[this.currentSlider.callLeft].call(this.color, left / this.currentSlider.maxLeft);
				}
				if (this.currentSlider.callTop) {
					this.color[this.currentSlider.callTop].call(this.color, top / this.currentSlider.maxTop);
				}
				// Change format dynamically
				// Only occurs if user choose the dynamic format by
				// setting option format to false
				if (this.currentSlider.callTop === 'setAlpha' && this.options.format === false) {

					// Converting from hex / rgb to rgba
					if (this.color.value.a !== 1) {
						this.format = 'rgba';
						this.color.origFormat = 'rgba';
					}

					// Converting from rgba to hex
					else {
						this.format = 'hex';
						this.color.origFormat = 'hex';
					}
				}
				this.update(true);

				this.element.trigger({
					type: 'changeColor',
					color: this.color
				});
				return false;
			},
			mouseup: function(e) {
				e.stopPropagation();
				e.preventDefault();
				$(document).off({
					'mousemove.colorpicker': this.mousemove,
					'touchmove.colorpicker': this.mousemove,
					'mouseup.colorpicker': this.mouseup,
					'touchend.colorpicker': this.mouseup
				});
				return false;
			},
			change: function(e) {
				this.keyup(e);
			},
			keyup: function(e) {
				if ((e.keyCode === 38)) {
					if (this.color.value.a < 1) {
						this.color.value.a = Math.round((this.color.value.a + 0.01) * 100) / 100;
					}
					this.update(true);
				} else if ((e.keyCode === 40)) {
					if (this.color.value.a > 0) {
						this.color.value.a = Math.round((this.color.value.a - 0.01) * 100) / 100;
					}
					this.update(true);
				} else {
					this.color = new Color(this.input.val(), this.options.colorSelectors);
					// Change format dynamically
					// Only occurs if user choose the dynamic format by
					// setting option format to false
					if (this.color.origFormat && this.options.format === false) {
						this.format = this.color.origFormat;
					}
					if (this.getValue(false) !== false) {
						this.updateData();
						this.updateComponent();
						this.updatePicker();
					}
				}
				this.element.trigger({
					type: 'changeColor',
					color: this.color,
					value: this.input.val()
				});
			}
		};

		$.colorpicker = Colorpicker;

		$.fn.colorpicker = function(option) {
			var pickerArgs = arguments,
				rv;

			var $returnValue = this.each(function() {
				var $this = $(this),
					inst = $this.data('colorpicker'),
					options = ((typeof option === 'object') ? option : {});
				if ((!inst) && (typeof option !== 'string')) {
					$this.data('colorpicker', new Colorpicker(this, options));
				} else {
					if (typeof option === 'string') {
						rv = inst[option].apply(inst, Array.prototype.slice.call(pickerArgs, 1));
					}
				}
			});
			if (option === 'getValue') {
				return rv;
			}
			return $returnValue;
		};

		$.fn.colorpicker.constructor = Colorpicker;

	}));
