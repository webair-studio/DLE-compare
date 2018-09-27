<?php
if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}

function get_result ($id){
  global $db;
    $db_count=clone $db;
  	$db_count->query( "SELECT answer, count(*) as count FROM " . PREFIX . "_vote_result WHERE vote_id='$id' GROUP BY answer" );

	$answer = array ();

	while ( $row_a = $db_count->get_row() ) {
		$answer[$row_a['answer']]['count'] = $row_a['count'];
	}
    unset($row_a);
  return $answer;     /*  */
}

	$db->query( "SELECT id, title, category, body, vote_num, start, end, grouplevel FROM " . PREFIX . "_vote WHERE approve=0  ORDER By id DESC" );//
    $vote='<table class="all_vote">';

	while ( $row = $db->get_row() ) {
        $body = explode( "<br />", $row['body'] );  // получили массив со строками ответов
        $vote.='<tr>
                <td colspan="2"><h3>'.$row['title'].'</h3>
                <div class="vote_time"> Дата проведения: с '.date('d-m-Y',$row['start']).' по '.date('d-m-Y',$row['end']).'</div>
                </td>
              </tr>';
      	$max = $row['vote_num'];
        $answer=get_result ($row['id']); // массив с результататми

		for($i = 0; $i < sizeof( $body ); $i ++) {

			++ $pn;
			if( $pn > 5 ) $pn = 1;

			$num = $answer[$i]['count'];
			if( ! $num ) $num = 0;
			if( $max != 0 ) $proc = (100 * $num) / $max;
			else $proc = 0;
			$proc = round( $proc, 2 );

			$vote .= "<tr><td class=\"vote_variant\">$body[$i] </td>
                          <td class=\"vote_result\">$num ($proc%)<!--<div class=\"voteprogress\"><span class=\"vote{$pn}\" style=\"width:".intval($proc)."%;\">{$proc}%</span>--></div>
                </td></tr>";

	}
  //  print_r($row);
   }
    $vote .='</table>';
	$db->free();
   echo $vote;
?>