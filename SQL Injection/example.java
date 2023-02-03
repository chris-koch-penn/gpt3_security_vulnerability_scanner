// Get username from parameters
String username = request.getParameter("username");
// Create a statement from database connection
Statement statement = connection.createStatement();  
String query = "SELECT secret FROM Users WHERE (username = '" + username + "' AND NOT role = 'admin')";
String query2 = String.format("SELECT secret FROM Users WHERE (username = '%s' AND NOT role = 'admin')", username);
// Execute query and return the results
ResultSet result = statement.executeQuery(query);
ResultSet result2 = statement.executeQuery(query2);
