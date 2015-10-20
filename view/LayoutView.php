<?php
/**
  * Solution for assignment 2
  * @author Daniel Toll
  */

class LayoutView {
  public function render($isLoggedIn, LoginView $v, DateTimeView $dtv, RegistrationView $r, EditView $ev) {
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>The Initiative for Procrastination</title>
  </head>
  <body>
    <h1>The Initiative for Procrastination</h1>
    <?php
      if($r->clickedRegister())
        echo $r->getLoginLink();
      elseif(!$isLoggedIn)
        echo $r->getRegLink();
      if ($isLoggedIn) {
        echo "<h2>Logged in</h2>";
        if($ev->clickedNewEntry())
          echo $ev->getStartLink();
        else {
          echo $ev->getEntryLink();
        }
      } else {
        echo "<h2>Not logged in</h2>";
    }
  ?>
    <div class="container" >
      <?php
      if($r->clickedRegister() && $r->regSuccess() === false)
        echo $r->response();
      if($ev->clickedNewEntry() && $ev->saveSuccess() === false) {
        echo $ev->response();
      }
      else
        echo $v->response();

        $dtv->show();
      ?>
    </div>

    <div>
      <em>This site uses cookies to improve user experience. By continuing to browse the site you are agreeing to our use of cookies.</em>
    </div>
   </body>
</html>
<?php
  }
}