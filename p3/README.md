# Project 3
+ By: Jeff Chen
+ Production URL: <https://e15p3.adejeffchen.me>

## Feature summary
This web app is a release calendar for Portfolio/Program/Project Managers who oversee a list of projects and their releases. Often in a big program, releases have dependencies. This web app helps the PMs to see the dependencies and their status quickly. 
+ Visitors can register/log in/log out
+ Non log in visitors can only browse the information and cannot make any changes to projects or releases 
+ Users can add/edit projects (project name, project manager, project description)
+ Users can add/edit releases for a project (release name, release date, release description, status)
  + Newly created release has status 'On Track' 
  + Release date can have unknown day or a specific day (usually a far away release only has year and month information)
  + New release can be added from the navigation bar or from a project detail page 
  + Releases on the project detail page is sorted by release date 
+ Users can add/edit release dependencies 
  + Only releases that have an earlier or same release date can be selected as a dependency 
  + Release detail page shows a list of dependencies that the current release depends on
  + Release detail page also shows a list of releases that the current release is a prerequisite of 
+ Everyone can search using the search box in the navigation bar
  + The search result will show any project or release' names and descriptions matching the search query 
+ The home page features
  + It displays a calendar view of the upcoming 12 months (if current month is April 2021, the view will cover April 2021 to March 2022)
  + Releases in the upcoming 12 months will be displayed according to the month
  + Assuming only one release per month for a given project 
  + Release shows the corresponding status color (green, yellow, red)
  + Release with unknown day will display with a question mark (?) after the month 
  
## Database summary
+ My application has 4 tables in total (`users`, `projects`, `releases`, `dependencies`)
+ There's a one-to-many relationship between `projects` and `releases`
+ There's a many-to-many relationship between `releases` and `releases`

## Outside resources
+ CSS framework - Bootstrap <https://getbootstrap.com/>
+ PHP Date Parameters <https://css-tricks.com/snippets/php/php-date-parameters/>
+ How to extract month, day from created_at column in Laravel? <https://stackoverflow.com/questions/45138724/how-to-extract-month-day-from-created-at-column-in-laravel>
+ Defining a many-to-many relationship with the same table <https://stackoverflow.com/questions/51551812/laravel-defining-a-many-to-many-relationship-with-the-same-table>
+ Laravel put null in created_at and updated_at while inserting new record <https://stackoverflow.com/questions/35716420/laravel-put-null-in-created-at-and-updated-at-while-inserting-new-record>
+ Eager loading of multiple nested relationships <https://stackoverflow.com/questions/35490728/laravel-eloquent-eager-loading-of-multiple-nested-relationships>
+ Keep line breaks in blade template <https://laravel.io/forum/01-22-2015-keep-line-breaks>
+ Fixed left column in a table <https://stackoverflow.com/questions/1312236/how-do-i-create-an-html-table-with-a-fixed-frozen-left-column-and-a-scrollable-b>
+ PHP Date() Function <https://www.w3schools.com/php/php_date.asp>