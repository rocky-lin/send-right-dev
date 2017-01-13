<?php
  require_once("vendor/autoload.php");

  $options = array(
    'encrypted' => true
  );
  $pusher = new Pusher(
    '5d4540ae0b86caedd37a',
    'e1663aa9083a9097aff2',
    '289307',
    $options
  );

  $data['message'] = 'hello world';
  $pusher->trigger('my-channel', 'my-event-erwin', $data);
?>