# The Frodo Application based on Lumen 5.x (current is 5.7) backend and VueJs 2.x (current is 2.5) frontend
## Working process
root:
- backend -> root
- frontend
    - dev -> root/frontend/src
    - prod -> root/frontend/app_dist
- Unit tests -> root/tests

###### Notice! Fronend getting data from localhost:8021
### API account request
[Postman Frodo API online Requests/Respones docs](https://web.postman.co/collections/5662109-1d9243d8-a84e-48ba-b1fa-710613c1671e?workspace=f67a518b-2f91-424e-8800-65e3d0c58899#a88f2dda-f407-4c3d-8731-ed60c89e5474)

Also available Postman [collection](https://github.com/TeeZ0NE/frodo_lumen/blob/dev/resources/Assets/frodo_postman_collection.json)

The diagram below shows the main processes for the user.
![Diagram of account](https://github.com/TeeZ0NE/frodo_lumen/blob/dev/resources/Assets/frodo_db-API-account-requests_responses.png)

### API posts request

![Posts request](https://github.com/TeeZ0NE/frodo_lumen/blob/dev/resources/Assets/frodo_db-API_posts-requests_responses.png)

All accounts are also available with their own posts on the URL *api/accounts/posts*

**Summary**

Action|Method|Path|Comment
-|:-:|:-:|-:
Create|POST|/api/accounts/new|using body screen_name and refresh interval. It take's 197 tweets by one. Twitter limits to 200 per once else it blocked, according to free plan
Get all with posts count|GET|/api/accounts|
Get all with posts|GET|/api/accounts/posts|With count results 5 per page and getting links to next one
Update account|POST|/api/accounts/{screen_name}| in body: name and interval
Delete account|POST|/api/accounts/{screen_name}/delete||
Get user posts|GET|/api/accounts/{screen_name}/posts[?limit=]|Optional parameter for getting last *limit* (default 100) posts|

After a new user is added, through the Twitter service of the application, it checks if there is such a user on the service and if he has posts and then downloads immediately them.

###### Notice! If add new user and he doesn't have any tweets, service send empty response without any data and he then won't store.

## Updating
Checks the time of the last update. If it coincides with the update interval - update tweets.
## Commands
### CRON
Run Scheduler globally

`* * * * * cd [path_to_project] && php artisan schedule:run`
### Via Artisan command line
`tweets:update`
### Frontend in another host
`npm serve [path_to_app_dist]` via NodeJs server
### Frontend in same host
`{BASE_URL}`
### Artisan Seeds
Available data seeeder. All accounts are not real for this
`db:seed` or `migrate:fresh [--seed]`.

## Screens
**Index**
![index page](https://github.com/TeeZ0NE/frodo_lumen/blob/dev/resources/Assets/appindex.png)

**Add channel**
![index page](https://github.com/TeeZ0NE/frodo_lumen/blob/dev/resources/Assets/add_user.png)

**Edit channel**
![index page](https://github.com/TeeZ0NE/frodo_lumen/blob/dev/resources/Assets/edit_user.png)

**Remove channel**
![index page](https://github.com/TeeZ0NE/frodo_lumen/blob/dev/resources/Assets/delete_user_confirm.png)

**Posts**
![index page](https://github.com/TeeZ0NE/frodo_lumen/blob/dev/resources/Assets/posts.png)
