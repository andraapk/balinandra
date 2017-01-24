{!! HTML::style('plugins/selectize/selectize.css') !!}
{!! HTML::style('plugins/selectize/selectize.bootstrap3.css') !!}
{!! HTML::script('plugins/selectize/selectize.min.js') !!}

<script type="text/javascript">
	$(document).ready(function() {
		var REGEX_EMAIL = '([a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@' +
		                  '(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)';

		var formatName = function(item) {
		    return $.trim((item.first_name || '') + ' ' + (item.last_name || ''));
		};

		$('#select-to').selectize({
		    persist: false,
		    maxItems: null,
		    valueField: 'email',
		    labelField: 'name',
		    searchField: ['first_name', 'last_name', 'email'],
		    sortField: [
		        {field: 'first_name', direction: 'asc'},
		        {field: 'last_name', direction: 'asc'}
		    ],
		    render: {
		        item: function(item, escape) {
		            var name = formatName(item);
		            return '<div>' +
		                (name ? '<span class="name">' + escape(name) + '</span>' : '') +
		                (item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
		            '</div>';
		        },
		        option: function(item, escape) {
		            var name = formatName(item);
		            var label = name || item.email;
		            var caption = name ? item.email : null;
		            return '<div>' +
		                '<span class="label">' + escape(label) + '</span>' +
		                (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
		            '</div>';
		        }
		    },
		    createFilter: function(input) {
		        var regexpA = new RegExp('^' + REGEX_EMAIL + '$', 'i');
		        var regexpB = new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i');
		        return regexpA.test(input) || regexpB.test(input);
		    },
		    create: function(input) {
		        if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
		            return {email: input};
		        }
		        var match = input.match(new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i'));
		        if (match) {
		            var name       = $.trim(match[1]);
		            var pos_space  = name.indexOf(' ');
		            var first_name = name.substring(0, pos_space);
		            var last_name  = name.substring(pos_space + 1);

		            return {
		                email: match[2],
		                first_name: first_name,
		                last_name: last_name
		            };
		        }
		        alert('Invalid email address.');
		        return false;
		    }
		});
		// SELECT2 
		// $('.select_tag_email').select2({
		// 	placeholder: 'pisahkan email dengan spasi atau koma',
		// 	// minimumResultsForSearch: Infinity,
		// 	tags: true,
		// 	tokenSeparators: [',', ' ', '\n', '\t', ';'],
		// 	createTag: function(term, data) {
		// 	    var value = term.term;
		// 	    if(validateEmail(value)) {
		// 	        return {
		// 	          id: value,
		// 	          text: value
		// 	        };
		// 	    }
		// 	    if (value === '') {
		// 		    return null;
		// 	    }
		// 	}
		// }).on('select2:select', function(e) {
		// 	$(this).val([]).trigger('change');
		// 	        $(this).val([e.params.data.id]).trigger("change");
		// });	
		// function validateEmail(email) {
		//     var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		//     return re.test(email);
		// }
	});
</script>