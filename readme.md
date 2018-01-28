# API TO DO LIST

The api has been tested with the POSTMAN application.
Start a new PHP server in your machine and run the command:

<code>php -S localhost:8080</code>
<h3>Insert new task:</h3>

<pre><code>http://localhost:8080/api/tasks/store</code></pre>

You need to select the post option on POSTMAN and send the fields in json format:
<pre>
<code>
{
    "type": "work",
    "content": "content test 1",
    "sort_order": "1",
    "done": "0"
}
</code>
</pre>
<h3>Update a task:</h3>

<pre><code>http://localhost:8080/api/tasks/update/{id}</i></code></pre>

You need to select the PUT option on POSTMAN and send the fields in json format:
<pre>
<code>
{
    "type": "shopping",
    "content": "content test 2",
    "sort_order": "2",
    "done": "0"
}
</code>
</pre>
<h3>Delete a task:</h3>

<pre><code>http://localhost:8080/api/tasks/destroy/{id}</code></pre>

You need to select the delete option on POSTMAN.
<h3>List all tasks:</h3>
<pre><code>http://localhost:8080/api/tasks/</code></pre>