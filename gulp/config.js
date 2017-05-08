'use strict';

module.exports = {

	'scripts' : {
		'concat': {
			'web' : 'scripts.js',
			'mobile': 'mobile.js',
			'angular': 'ng.js'
		},
		'source': {
			'web' : [
				'web/js/site/*.js',
				'!web/js/scripts.js'
			],
			'mobile' : ['web/js/mobile/*.js'],
			'angular' : [
                'web/js/ngApp/**/*.js',
                'web/js/ngApp/**/**/*.js'
			]
		}
	},

	'styles' : {
		'concat': {
			'web' : 'styles.css',
			'admin' : 'admin.css',
			'angular' : 'ng.css',
			'mobile' : 'mobile.css'
		},
		'source' : {
			'web' : ['web/css/sass/*.scss'],
			'admin' : ['web/css/sass/admin/*.scss'],
			'mobile' : ['web/css/sass/mobile/*.scss'],
			'angular' : ['web/js/ngApp/**/**/*.scss']

        }
	},
	'dist' : {
		'files' : {
			'css' : 'web/css',
			'js' : 'web/js'
		}
	}
};
