/*!
 * Grunt file
 *
 * @package ContactPage
 */

/*jshint node:true */
module.exports = function ( grunt ) {
	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-jsonlint' );

	grunt.initConfig( {
		banana: {
			"ContactPage": [
				"i18n"
			]
		},
		jsonlint: {
			all: [
				'**/*.json',
				'!node_modules/**'
			]
		}
	} );

	grunt.registerTask( 'test', [ 'jsonlint', 'banana' ] );
	grunt.registerTask( 'default', 'test' );
};
