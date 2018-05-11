/* jshint node:true */
module.exports = function( grunt ) {
	require( 'load-grunt-tasks' )( grunt );

	// Project configuration.
	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),

		// PHPLint
		phplint: {
			core: [
				'src/**/*.php'
			]
		},

		// PHP Code Sniffer
		phpcs: {
			core: {
				src: [
					'src/**/*.php'
				]
			},
			options: {
				bin: 'vendor/bin/phpcs',
				standard: 'phpcs.xml.dist',
				showSniffCodes: true
			}
		},

		// PHPUnit
		phpunit: {
			options: {
				bin: 'vendor/bin/phpunit'
			},
			classes: {
				
			}
		},
		
		// Check textdomain errors
		checktextdomain: {
			options:{
				text_domain: 'pronamic-money',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src:  [
					'src/**/*.php'
				],
				expand: true
			}
		},

		// Make POT
		makepot: {
			target: {
				options: {
					domainPath: 'languages',
					type: 'wp-plugin',
					mainFile: 'pronamic-money.php',
					updatePoFiles: true,
					updateTimestamp: false,
					exclude: [
						'vendor/.*',
						'wordpress/.*'
					],
					include: [
						'src/.*'
					]
				}
			}
		}
	} );

	// Default task(s).
	grunt.registerTask( 'default', [ 'phplint', 'phpcs', 'phpunit' ] );
	grunt.registerTask( 'pot', [ 'checktextdomain', 'makepot' ] );
};
