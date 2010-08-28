<%@page import="java.net.*"%>
<%@page import="java.io.*;"%>

<% 
URL url = new URL("http://localhost:8080/MyProject/MyProject/facebook");
	URLConnection connection = url.openConnection();
	System.out.println("Opened Url connection");
	connection.setDoOutput(true);





	
%>
