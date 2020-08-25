# Status

This is a sign in and sign out system for office use, It uses a Vue.js frontend with a Laravel backend connecting to a python3 [facial recognotion script](https://github.com/michaelmano/facial-recognition) which returns a json response.

You can view the [app/FacialRecognition.php](app/FacialRecognition.php) class here which runs the python script using Symfony's Process and stores all new images in the public directory under the users name for future training which runs via a cronjob on the server.

The frontend which can be viewed here [resources/assets/js/vue/Camera.vue](resources/assets/js/vue/Camera.vue)

If a face is detected and not recognised it will ask you to select from a list of employees which one it is. It will then store that image in a folder with the users name to use for training that night. If the face is recognised it will ask you to confirm and sign out.

It also uses a namepad built in vue for general use without camera.

## Example screen shots

!["Step 1"](docs/1.jpg?raw=true)
!["Step 2"](docs/2.jpg?raw=true)
!["Step 3"](docs/3.jpg?raw=true)
!["Step 4"](docs/4.jpg?raw=true)
!["Step 5"](docs/5.jpg?raw=true)
!["Step 6"](docs/6.jpg?raw=true)
!["Step 7"](docs/7.jpg?raw=true)
!["Step 8"](docs/8.jpg?raw=true)
!["Step 9"](docs/9.jpg?raw=true)