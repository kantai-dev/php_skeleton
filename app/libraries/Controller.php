<?php

    /**
     * Base controller
     * Loads the models and views
     */

     class Controller {

        /**
         * Method to load a given model,
         * find the required model and then return a new instance
         * 
         * @param model Name of the model to load
         * 
         * @return Model
         */
        public function model($model) {
            require_once '../app/models/' . $model . '.php';

            return new $model;
        }

        /**
         * Method to load a given view with parsed data,
         * also handles non-existant views
         * 
         * @param view  Name of the view to load
         * @param data  Array of data to parse the view
         * 
         */
        public function view($view, $data = []) {
            if (file_exists('../app/views/' . $view . '.php')) {
                require_once '../app/views/' . $view . '.php';
            } else {
                die('View does not exist');
            }
        }

     }

?>