Symfony AI Weather Fluctuation Calculator


Installation
To get started with the Symfony AI Weather Comparer project, follow these steps:

Prerequisites
Ensure you have the following installed on your machine:

PHP (>= 8.1)
Composer
Symfony CLI
Git
Step-by-Step Guide
Clone the repository:

Open your terminal and run the following command in the director of your choice to create the project in, to clone the repository to your local machine:

git clone https://github.com/max-behrens/Symfony-AI-Weather-Comparer.git



Navigate into the project directory


Install project dependencies:

Use Composer to install all necessary dependencies:

composer install



Set up the environment:

Copy the .env file to create your local environment configuration:

cp .env.example .env
In the .env file, make sure to update the API keys for the weather service, and OpenAI, if necessary.

Set up the database:

Run the following command to create and update the database schema:

php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
Start the Symfony development server:



If you have the Symfony CLI installed, you can run:

symfony server:start


This will start the local server. If you do not have Symfony CLI, you can use the built-in PHP server:

php -S 127.0.0.1:8000 -t public/


Access the application:

Open your web browser and navigate to http://127.0.0.1:8000. You should see the application running locally.




Usage:



Weather Calculator

In the Weather Calculator page, you can search for the current weather of any city and view the historical monthly weather data for that city.

The weather data is fetched from the OpenWeather API and displayed on the page. You can use this data to compare current and previous weather conditions for the city of your choice.

Additionally, the system calculates the rate of change in weather data between the current and previous data, along with an OpenAI explanation of the calculated value in terms of recorded climate data.

This rate of change, along with its explanation, can be saved as a calculation to view later in the Calculation Manager.

Calculation Manager

The Calculation Manager is a CRUD (Create, Read, Update, Delete) application where users can perform the following actions:

Add Calculations: You can add your own calculations based on the weather data and the explanations provided.
View Calculations: All saved calculations are available in the Calculation Manager.
Edit Calculations: You can modify any of your previously saved calculations.
Delete Calculations: If you no longer need a calculation, you can delete it from the list.
Calculations can be made directly from the Weather Calculator page or can be manually added and edited from the Calculation Manager.