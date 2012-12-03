<?php
INCLUDE_ONCE 'include/headCode.php';

header('Content-type: text/xml');
connectToDb();

$xml = new SimpleXMLElement('<xml/>');
$res = $xml->addChild('response');
$photos = $res->addChild('photos');

$result = sql("select * from photos where private=0 order by views, created_at desc");

while($photo_data = mysql_fetch_array($result)){
  $photo = $photos->addChild('photo');
  $path = str_replace(" ", "%20", $photo_data["path"]);
  $photo->addAttribute("name", $photo_data['title']);
  $photo->addAttribute("src", $baseURL.$path);
  $photo->addAttribute("thumb", $baseURL.$path);
  $photo->addAttribute("views", $photo_data['views']);
  $photo->addAttribute("updated_at", $photo_data['updated_at']);
  $photo->addAttribute("created_at", $photo_data['created_at']);
  $photo->addAttribute("description", $photo_data['description']);
  $photo->addAttribute("id", $photo_data['id']);

  $comments = $photo->addChild('comments');
  $comments_result = sql("select text, name, email, comments.created_at from comments left join users on comments.user_id = users.id where photo_id = " . $photo_data['id'] . ";");
  while($comment_data = mysql_fetch_array($comments_result)){
    $comment = $comments->addChild('comment');
    $comment->addAttribute("text", $comment_data['text']);
    $comment->addAttribute("username", $comment_data['name']);
    $comment->addAttribute("email", $comment_data['email']);
    $comment->addAttribute("date", $comment_data['created_at']);
    $comment->addAttribute("created_at", $comment_data['created_at']);
  }
  // <comment text='Example comment 5.0' username='example_username_8' date='2012-11-15 12:10:16' />

}

print($xml->asXML());


// <!-- 
// <response>
// <photos>
// <photo name='Example picture 0' src='http://lorempixel.com/909/837/' thumb='http://lorempixel.com/100/100/'>
// <comments>
// <comment text='Example comment 0.0' username='example_username_11' date='2012-11-13 12:14:48' />
// <comment text='Example comment 0.1' username='example_username_0' date='2012-11-14 12:11:33' />
// <comment text='Example comment 0.2' username='example_username_10' date='2012-11-15 12:13:22' />
// <comment text='Example comment 0.3' username='example_username_7' date='2012-11-16 12:17:26' />
// </comments> 
// -->
?>