# Art Challenge

Welcome to Art Challenge, a web application where users can participate in art challenges.
All techniques like drawing, painting, and digital art are allowed.
Once the challenge is completed, users can vote on their favorite entries.

## Features

- Daily and weekly challenges with unique themes
- Users can upload their entries for ongoing challenges
- Voting system for users to vote on their favorite entries
- Explore page with all challenges and entries
- Private user gallery

## Requirements:

- [Docker](https://www.docker.com/)

## Installation

1. Clone the repository from Github:

       git clone https://github.com/wojzam/wdpai.git

2. In the root directory of the cloned repository, run the following command to build the Docker images:

       docker-compose build

## Running the App

1. Run the following command to start the app:

       docker-compose up

   Once the app is set up, you can access it by visiting http://localhost:8080 in your web browser.

2. To stop the app, you can use the following command:

       docker-compose down

## Technical details

- Technology stack: PHP, HTML, CSS, JavaScript
- Database: PostgreSQL
- Containerization: Docker

### Database ERD

![database-erd](/ERD.png)

## Screenshots

![screen-home](/public/img/screenshots/screen_home.jpg)

![screen-join](/public/img/screenshots/screen_join.jpg)

![screen-collection](/public/img/screenshots/screen_collection.jpg)

![screen-explore](/public/img/screenshots/screen_explore.jpg)

## TODO

- [ ] Add moderator role, which can add and manage challenges
- [ ] Implement voting system
- [ ] Improve mobile version (hamburger menu)
- [ ] Clean up local files after user account deletion etc.
