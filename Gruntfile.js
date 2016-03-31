module.exports = function (grunt) {

    // ===========================================================================
    // CONFIGURE GRUNT ===========================================================
    // ===========================================================================
    grunt.initConfig({

        // get the configuration info from package.json ----------------------------
        // this way we can use things like name and version (pkg.name)
        pkg: grunt.file.readJSON('package.json'),

        // all of our configuration will go here
        copy: {
            build: {
                files: [
                    {
                        expand: true,
                        src: ['bower_components/samizdatco-arbor/lib/*'],
                        dest: 'Resources/Public/js/samizdatco-arbor/',
                        filter: 'isFile',
                        flatten: true
                    }
                ]
            }
        }

    });

    // ===========================================================================
    // LOAD GRUNT PLUGINS ========================================================
    // ===========================================================================
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.registerTask('default', 'copy');

};
