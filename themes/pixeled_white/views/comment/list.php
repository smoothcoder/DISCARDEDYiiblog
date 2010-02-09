<h2>Comments Pending Approval</h2>

<h3><?php echo count($comments) . (count($comments)>1 ? ' comments':' comment'); ?> to approve</h3>

<?php $this->renderPartial('_list',array(
	'comments'=>$comments,
)); ?>

<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>




<form action="" method="post" id="akismet-connectivity" style="margin: auto; width: 400px; ">

<h3><?php Yii::t('lan','Server Connectivity'); ?></h3>
<?php
	$akismet=Yii::app()->CAkismetComponent;
	$servers = $akismet->akismet_get_server_connectivity();
	$fail_count = count($servers) - count( array_filter($servers) );
	if ( is_array($servers) && count($servers) > 0 ) {
		// some connections work, some fail
		if ( $fail_count > 0 && $fail_count < count($servers) ) { ?>
			<p style="padding: .5em; background-color: #aa0; color: #fff; font-weight:bold;"><?php echo Yii::t('lan','Unable to reach some Akismet servers.'); ?></p>
			<p><?php echo sprintf( __('A network problem or firewall is blocking some connections from your web server to Akismet.com.  Akismet is working but this may cause problems during times of network congestion.  Please contact your web host or firewall administrator and give them <a href="%s" target="_blank">this information about Akismet and firewalls</a>.'), 'http://blog.akismet.com/akismet-hosting-faq/'); ?></p>
		<?php
		// all connections fail
		} elseif ( $fail_count > 0 ) { ?>
			<p style="padding: .5em; background-color: #d22; color: #fff; font-weight:bold;"><?php echo Yii::t('lan','Unable to reach any Akismet servers.'); ?></p>
			<p><?php echo sprintf( 'A network problem or firewall is blocking all connections from your web server to Akismet.com.  <strong>Akismet cannot work correctly until this is fixed.</strong>  Please contact your web host or firewall administrator and give them <a href="%s" target="_blank">this information about Akismet and firewalls</a>.', 'http://blog.akismet.com/akismet-hosting-faq/'); ?></p>
		<?php
		// all connections work
		} else { ?>
			<p style="padding: .5em; background-color: #2d2; color: #fff; font-weight:bold;"><?php echo  Yii::t('lan','All Akismet servers are available.'); ?></p>
			<p><?php Yii::t('lan','Akismet is working correctly.  All servers are accessible.'); ?></p>
		<?php
		}
	} elseif ( !is_callable('fsockopen') ) {
		?>
			<p style="padding: .5em; background-color: #d22; color: #fff; font-weight:bold;"><?php echo Yii::t('lan','Network functions are disabled.'); ?></p>
			<p><?php echo sprintf( 'Your web host or server administrator has disabled PHP\'s <code>fsockopen</code> function.  <strong>Akismet cannot work correctly until this is fixed.</strong>  Please contact your web host or firewall administrator and give them <a href="%s" target="_blank">this information about Akismet\'s system requirements</a>.', 'http://blog.akismet.com/akismet-hosting-faq/'); ?></p>
		<?php
	} else {
		?>
			<p style="padding: .5em; background-color: #d22; color: #fff; font-weight:bold;"><?php echo Yii::t('lan','Unable to find Akismet servers.'); ?></p>
			<p><?php echo sprintf( 'A DNS problem or firewall is preventing all access from your web server to Akismet.com.  <strong>Akismet cannot work correctly until this is fixed.</strong>  Please contact your web host or firewall administrator and give them <a href="%s" target="_blank">this information about Akismet and firewalls</a>.', 'http://blog.akismet.com/akismet-hosting-faq/'); ?></p>
		<?php
	}

	if ( !empty($servers) ) {
?>
<table style="width: 100%;">
<thead><th><?php echo Yii::t('lan','Akismet server'); ?></th><th><?php echo Yii::t('lan','Network Status'); ?></th></thead>
<tbody>
<?php
		asort($servers);
		foreach ( $servers as $ip => $status ) {
			$color = ( $status ? '#2d2' : '#d22');
	?>
		<tr>
		<td><?php echo htmlspecialchars($ip); ?></td>
		<td style="padding: 0 .5em; font-weight:bold; color: #fff; background-color: <?php echo $color; ?>"><?php echo ($status ? 'No problems' :'Obstructed' ); ?></td>

	<?php
		}
	}
?>
</tbody>
</table>
	<p><?php /*if ( get_option('akismet_connectivity_time') ) echo sprintf( __('Last checked %s ago.'), human_time_diff( get_option('akismet_connectivity_time') ) );*/ ?></p>
</form>


