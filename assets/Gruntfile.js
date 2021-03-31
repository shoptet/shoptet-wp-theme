module.exports = function(grunt) {

    require("load-grunt-tasks")(grunt);

    grunt.initConfig({
        sass: {
            production: {
                options: {
                    style: 'expanded'
                },
                files: {
                    'shoptet.css': 'shoptet.scss'
                }
            }
        },
        watch: {
            css: {
                files: [
                    'shoptet.scss',
                    'shoptet/*.scss',
                ],
                tasks: ['sass'],
                options: {
                    livereload: 35729
                }
            },
        }
    });

    grunt.registerTask('default', ['sass']);

};
