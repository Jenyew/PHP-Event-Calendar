<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function showAddEvent() {
    //Show add event in main part of dashboard.
    print "This is where I add an event!";
}

function showAllEvents() {
    //Show all events in main part of dashboard.
    print "These are all of the events!";
    
    //Todays Events
    print '
          <h2 class="sub-header">Events Today</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th>Category</th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Meeting</td>
                  <td>9:30AM Wednesday, April 29, 2015</td>
                  <td>10:30AM Wednesday, April 29, 2015</td>
                  <td>
                      <button type="button" class="btn btn-xs btn-default">Meetings</button>
                      <button type="button" class="btn btn-xs btn-default">Staff</button>
                      <button type="button" class="btn btn-xs btn-default">10th Grade</button>
                  </td>
                  <td><button type="button" class="btn btn-xs btn-info">Edit Event</button></td>
                </tr>
              </tbody>
            </table>
          </div>';
    
    
    //This week's Events
    print '
          <h2 class="sub-header">Events This Week</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th>Category</th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Meeting</td>
                  <td>9:30AM Wednesday, April 29, 2015</td>
                  <td>10:30AM Wednesday, April 29, 2015</td>
                  <td>
                      <button type="button" class="btn btn-xs btn-default">Meetings</button>
                      <button type="button" class="btn btn-xs btn-default">Staff</button>
                      <button type="button" class="btn btn-xs btn-default">10th Grade</button>
                  </td>
                  <td><button type="button" class="btn btn-xs btn-info">Edit Event</button></td>
                </tr>
                <tr>
                  <td>Meeting</td>
                  <td>9:30AM Friday, May 1, 2015</td>
                  <td>10:30AM Friday, May 1, 2015</td>
                  <td>
                      <button type="button" class="btn btn-xs btn-default">Meetings</button>
                      <button type="button" class="btn btn-xs btn-default">Staff</button>
                      <button type="button" class="btn btn-xs btn-default">10th Grade</button>
                  </td>
                  <td><button type="button" class="btn btn-xs btn-info">Edit Event</button></td>
                </tr>
              </tbody>
            </table>
          </div>';
}
