<?php
//COUNT SURVEYS
$stm_surveys = $connection->prepare('SELECT COUNT(*) FROM user_survey WHERE userid=?');
$stm_surveys->bind_param("i", $_SESSION[SESSION_USERID]);
$stm_surveys->execute();
$stm_surveys->bind_result($count_surveys);
$stm_surveys->fetch();
$stm_surveys->free_result();
//FAVORITE EMOJI
$stm_emoji = $connection->prepare('SELECT answer.MediaPath, COUNT(answer.MediaPath) as count FROM answer JOIN user_answer ON user_answer.AnswerID=answer.AnswerID WHERE answer.InfoTypeID=? AND user_answer.UserID=? GROUP BY answer.MediaPath ORDER BY count DESC LIMIT 1');
$typeid = INFO_EMOJI;
$stm_emoji->bind_param("ii", $typeid, $_SESSION[SESSION_USERID]);
$stm_emoji->execute();
$stm_emoji->bind_result($emoji_code, $emoji_count);
$stm_emoji->fetch();
$stm_emoji->free_result();
$emoji_code = $emoji_code == null ? '-' : $emoji_code;
//AVG TIME
$stm_emoji = $connection->prepare('SELECT answer.MediaPath, COUNT(answer.MediaPath) as count FROM answer JOIN user_answer ON user_answer.AnswerID=answer.AnswerID WHERE answer.InfoTypeID=? AND user_answer.UserID=? GROUP BY answer.MediaPath ORDER BY count DESC LIMIT 1');
$typeid = INFO_EMOJI;
$stm_emoji->bind_param("ii", $typeid, $_SESSION[SESSION_USERID]);
$stm_emoji->execute();
$stm_emoji->bind_result($emoji_code, $emoji_count);
$stm_emoji->fetch();
$stm_emoji->free_result();
