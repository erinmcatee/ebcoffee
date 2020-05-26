module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // read the package.json file so we know what packages we have
    pkg: grunt.file.readJSON('package.json'),
    // config options used in the uglify task to minify scripts
    uglify: {
      options: {
        // this adds a message at the top of the file with todays date to indicate build date
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
        output: {
	        comments: 'some'
        }
      },
      build: {
        src: 'wp-content/themes/x-child/src/js/scripts.js',
        dest: 'wp-content/themes/x-child/assets/js/scripts.min.js'
      }
    },
    // config options for the cssmin task to minify stylesheets
    cssmin: {
	  options: {
		  keepSpecialComments: 1
	  },
      minify: {
        src: 'wp-content/themes/x-child/src/css/style.css',
        dest: 'wp-content/themes/x-child/style.css'
      }
    },
    
    sass: {
	    prod: {
		    files: {
			    'wp-content/themes/x-child/src/css/style.css': 'wp-content/themes/x-child/src/scss/main.scss'
		    }
	    }
    },
    
	watch: {
		/*
		uglify: {
			files: 'wp-content/themes/x-child/src/js/scripts.js',
			tasks: ['uglify']
		},
		cssmin: {
			files: 'wp-content/themes/x-child/src/css/style.css',
			tasks: ['cssmin']
		},
		*/
		sass: {
			files: ['wp-content/themes/x-child/src/scss/*.scss', 'wp-content/themes/x-child/src/scss/**/*.scss',],
			tasks: ['sass', 'cssmin']
		}
	}
  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');
  // Load the plugin that provides the "cssmin" task.
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  // Load the plugin that provides the "sass" task.
  grunt.loadNpmTasks('grunt-contrib-sass');
  // Load the plugin that provides the "watch" task.
  grunt.loadNpmTasks('grunt-contrib-watch');


  // Sass task
  // grunt.registerTask('build', ['sass:prod']);
  // Default task(s).
  grunt.registerTask('default', ['sass:prod', 'uglify', 'cssmin', 'watch']);

};