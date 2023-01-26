# Art Challenge

Welcome to Art Challenge, a web application where users can participate in daily and weekly drawing/painting challenges.
Each challenge will have a specific topic and users can submit their entries.
Once the challenge is completed, users can vote on their favorite entries.
Everyone, including non-registered users, can browse completed challenges and view entries, but only registered users
can vote.
Each registered user has the option to view their personal gallery containing all their entries.

## Features

- Daily and weekly challenges with different themes
- Users can upload their entries for ongoing challenges
- Voting system for users to vote on their favorite entries
- Explore page with all challenges and entries
- Private user gallery with uploaded entires

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
