# Workana Hiring challenge

Hi!

We are looking for great PHP and Javascript developers to join our team. 
Instead of going through a ~~boring~~ long interview process, we decided that code often speaks for itself. 
If you're up to the challenge, please take a couple of hours to play with this challenge and submit your solution.

## The Planning Poker Lobby

[![See demo interface](https://user-images.githubusercontent.com/281727/100144788-13509980-2e76-11eb-8ae4-264f94928225.png)](https://codepen.io/emilioastarita/pen/NWRKWwv)

This time let's build a little [planning poker](https://en.wikipedia.org/wiki/Planning_poker) system. The exercise 
will work in multiple levels (while you're 
not supposed to work on all of them we hope that you can handle at least one with a good level of expertise).

### At backend layer you can choose among three options:

- **Mocked Service** mock your responses in the client side using async functions (use this option if you are front developer)
- **Node Js Backend** Here you can use express, implement your own server or any framework of your preference. If you go with this option 
we expect to see more realtime features.
- **PHP Server**  If you go with PHP please pick a light framework. We expect to see more enterprise level software with robust error handling at API level. 
Bonus if you use PHP 8 features.


### Backend endpoints to implement

Let's build a REST API with the following endpoints. Feel free to change some things these 
descriptions are only for guidance. 

##### `POST /issue/{:issue}/join` - Used to join `{:issue}`. 
   - If issue not exists generate a new one.
   - Must receive a payload with the intended name. ie: `{"name": "florencia"}`
   - Feel free to use a session or token to keep identified the user in subsequent requests.
 
##### `POST /issue/{:issue}/vote` - Used to vote `{:issue}`. Must receive a payload with the vote value.
   - Reject votes when status of `{:issue}` is not `voting`. 
   - Reject votes if user not joined `{:issue}`. 
   - Reject votes if user already `voted` or `passed`. 
  
##### `GET /issue/{:issue}` - Returns the status of issue
   Because during `voting` status the votes are secret you must hide each vote until all members voted.
   - Issue is `voting`: 
        ````json
        {
         "status": "voting", 
         "members": [
              {"name": "florencia", "status": "voted"}, 
              {"name": "kut", "status": "waiting"}, 
              {"name": "lucho", "status": "passed"}
          ]
         }
        ````
   - Issue is `reveal` when all users emitted their votes: 
        ````json
            {
                "status": "reveal", 
                "members": [
                    {"name": "florencia", "status": "voted", "value": 20}, 
                    {"name": "kut", "status": "voted", "value": 20}, 
                    {"name": "lucho", "status": "passed"}
                ],
               "avg": 20
            }
       ````

#### Realtime 

If you are implementing backend with node could be nice to have a collection of events notifying clients about new votes
and changes using some kind of realtime technology of your choice as websockets or long-polling. 

#### Persistence

For persistence use the `redis` service provided in docker-compose and choose the best combination of operation/data structures
that serves  for your solution.

If you don't want to mess too much with the backend, and you are in the node path you can use `in memmory` persistence but please
provide some kind of abstraction around your store. 


**Bonus points** if you can provide some hints around horizontal scalability of the backend service using `redis` features.     


### Frontend

Provide an interface to use the system. 


If you are backend developer and don't want to build a front give us a bunch of `curl`s showing how to query
the status and how to do some votes.

If you want to work on frontend use Vue 2 or Vue 3 to construct an interface:

 - Take a look at [our Codepen](https://codepen.io/emilioastarita/pen/NWRKWwv) if you are looking for some inspiration or ideas.
 - Create or join an issue by number
 - Show board with cards for voting 
 - Show a list of members and the status of each one
 - Allow users to vote, pass or leave the issue
 - Bonus points if you handle client side routing (you can use libs)

If you prefer to work only on front side no problem! Just fake the data using a bunch of  async local functions and handle
a global state holding your data at the root component.

```javascript
async function getMembers() { 
   return [
       {"name": "florencia", "status": "voted", "value": 20}, 
       {"name": "kut", "status": "voted", "value": 20}, 
       {"name": "lucho", "status": "passed"}
   ];
}
```
 
We are interested to know how you work and if you are able to produce quality code, so take some time to think around 
details and put some effort to treat errors with robustness. 
Feel free to guide us to review your code and explain where you put more effort
or what you were thinking when you take the key design decisions.   

#### Some considerations:
 - The demo is in a single component, but it's better if you can use many, and demonstrate how would you communicate between them. "Divide and Conquer" :muscle:
 - Try to use good conventions and semantically correct names for variables & functions.
 - Take advantage of vue reactivity with computed properties and its two-way data-binding :twisted_rightwards_arrows:

## Get up and running

To run this code you need:
  - [Docker](https://www.docker.com/get-started) and [docker-compose](https://docs.docker.com/compose/install/) installed

Then:
  - Clone this repo: `git clone git@github.com:Workana/hiring_challenge.git`.
  - Run `docker-compose up`.
  
Check if services are up and running:
  - Node backend in [localhost:8082](http://localhost:8082/issue/234)
  - PHP backend in [localhost:8081](http://localhost:8081/issue/234)
  - Front dev server with demo in [localhost:8080](http://localhost:8080/)


## What we would like you to do?

Download this repo. Code it your way. Choose what parts of the system you want to implement and put your best effort doing it.

- Some unit testing is mandatory.
- Although we love other languages too, we prefer if you stick to PHP, Javascript or Typescript, as these are 
Workana main languages.



## Submission

 Please don't submit Pull Requests. After you're done, please email to [labs+hiring@workana.com](mailto:labs+hiring@workana.com) 
 with the link to your fork, so we can start talking =)

Thanks a lot and happy coding!

