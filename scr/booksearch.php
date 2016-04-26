<!DOCTYPE HTML>

<html>
    <head>
        <title>Book browser</title>
    </head>

    <body>

        <?php

            $searchAuthor = $_POST["search_author"];
            $searchTitle = $_POST["search_title"];

            if(!$searchTitle && !$searchAuthor) {
                printf("You must specify either title or an author.");
                exit();
            }

           $searchTitle = addslashes($searchTitle);
           $searchAuthor = addslashes($searchAuthor);

        try{
            $db = new PDO("mysql:host=localhost;dbname=library", "root", "root");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
            printf("Unable to open database: %s\n", $e->getMessage());
        }

        $query = " select * from books";

        if ($searchTitle && !$searchAuthor) {
            $query = $query . " where title like '%" . $searchTitle . "%'";
        }
        else if (!$searchTitle && !$searchAuthor) {
            $query = $query . " where author like '%" . $searchAuthor . "%'";
        }
        else{
            $query = $query . " where author like '%" . $searchAuthor . "%'" . " and author like '%" . $searchAuthor . "%'";
        }

        printf("Debug: ruuuning query");

        try{
            $sth = $db->query($query);
            $bookCount = $sth->rowCount();
            if($bookCount == 0 ){
                printf("Sorry we did not find any matching books");
            }

            printf('<table cellpadding="6">');
            printf('<tr><td>Title</td> <td>Author</td></tr>');
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                printf("<tr><td> %s </td> <td> %s </td> </tr>", htmlentities($row["title"]), htmlentities($row["author"]));
            }

            printf('</table>');

        }
        catch (PDOException $e) {
            printf("We encountered a problem: %s\n", $e->getMessage());
        }

        printf("We found %s matching books", $bookCount);

        ?>
    </body>
</html>
