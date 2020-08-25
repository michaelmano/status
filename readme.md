# Status

This is a sign in and sign out system for office use, It uses a Vue.js frontend with a Laravel backend connecting to a python3 [facial recognotion script](https://github.com/michaelmano/facial-recognition) which returns a json response.

You can view the [app/FacialRecognition.php](app/FacialRecognition.php) class here which runs the python script using Symfony's Process and stores all new images in the public directory under the users name for future training which runs via a cronjob on the server.

The frontend which can be viewed here [resources/assets/js/vue/Camera.vue](resources/assets/js/vue/Camera.vue)

If a face is detected and not recognised it will ask you to select from a list of employees which one it is. It will then store that image in a folder with the users name to use for training that night. If the face is recognised it will ask you to confirm and sign out.

It also uses a namepad built in vue for general use without camera.

## Example screen shots

### With facial recognition

!["Step 1"](https://raw.githubusercontent.com/michaelmano/status/master/docs/1.png)
!["Step 2"](https://raw.githubusercontent.com/michaelmano/status/master/docs/2.png)

### Manual keypad

!["Step 3"](https://raw.githubusercontent.com/michaelmano/status/master/docs/3.png)
!["Step 4"](https://raw.githubusercontent.com/michaelmano/status/master/docs/4.png)
!["Step 5"](https://raw.githubusercontent.com/michaelmano/status/master/docs/5.png)
!["Step 6"](https://raw.githubusercontent.com/michaelmano/status/master/docs/6.png)
!["Step 7"](https://raw.githubusercontent.com/michaelmano/status/master/docs/7.png)
!["Step 8"](https://raw.githubusercontent.com/michaelmano/status/master/docs/8.png)
!["Step 9"](https://raw.githubusercontent.com/michaelmano/status/master/docs/9.png)