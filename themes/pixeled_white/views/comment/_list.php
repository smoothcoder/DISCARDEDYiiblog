<div id="comments">
	<ul class="commentlist">
	<?php foreach($comments as $comment): ?>

		<?php if(Yii::app()->user->isGuest && $comment->status==Comment::STATUS_PENDING) continue; ?>
		<li id="li-comment-<?php echo $comment->id; ?>">
			<div class="ccomment" id="c<?php echo $comment->id; ?>">
				<div id="comment-<?php echo $comment->id; ?>">
					<?php /*echo CHtml::link("#{$comment->id}",array('post/show','id'=>isset($post)?$post->id:$comment->post->id,'#'=>$comment->id),array(
					'class'=>'cid',
					'title'=>'Permalink to this comment',
					));*/ ?>
					<div id="commentbody">
						<div class="author"><?php $this->get_gravatar($comment->email);
							echo '<b>'.$comment->getAuthorUrl()."</b>  ";?> says:
						</div>

						<div class="time">
							<?php if( (!Yii::app()->user->isGuest) && (Yii::app()->user->status==User::STATUS_ADMIN) ): ?>
								<?php ($comment->status==Comment::STATUS_PENDING)
									?$appPend=Yii::t('lan','Approve'):
									$appPend=Yii::t('lan','UnApprove');
									($comment->status==Comment::STATUS_PENDING)
									?$appColor='red':
									$appColor=''; ?>

								<?php echo CHtml::ajaxLink($appPend,
									$this->createUrl('comment/ajaxApprove',array('id'=>$comment->id)),
									array('success'=>'function(msg){ pThis.html(msg); }'),
									array('onclick'=>'var pThis=$(this)','style'=>'color:'.$appColor )); ?> |
								<?php /*endif; */?>


								<?php echo CHtml::link('Update',array('comment/update','id'=>$comment->id)); ?> |

								<?php echo CHtml::ajaxLink(Yii::t('lan','Delete'),
									$this->createUrl('comment/ajaxDelete',array('id'=>$comment->id)),
									array('success'=>'function(msg){ $("#c'.$comment->id.'").animate({ opacity: "hide" }, "slow"); }',
										'beforeSend' => 'function(){$("#myDiv").addClass("loading");}',
										'complete' => 'function(){$("#myDiv").removeClass("loading");}',
								)); ?>
								<?php
									echo  ' <br/> '.$comment->getAuthorEmail();
									echo ' <em>('.$comment->getAuthorIP().')</em> ';
									echo $comment->getSpamText().' ' ;
								?>

							<?php endif; ?>

							<?php
								$displaydate=date('F j, Y \a\t h:i a',$comment->createTime);
								$displayid=isset($post)?$post->id:$comment->post->id;
								$displaycid='comment-'.$comment->id;
								echo CHtml::link( $displaydate ,
											array('post/show','slug'=>$post->slug,'#'=>$displaycid),
											array(
												'class'=>'cid',
												'title'=>'Permalink to this comment',
							));?>

						</div><!-- time -->
						<div class="cite"><?php echo /*htmlspecialchars_decode(*/ $comment->contentDisplay/*)*/ ; ?></div>
					</div>
				</div> <!-- comment-XX -->
				<div class="cleared"></div>
			</div><!-- ccomment -->
		</li>
	<?php endforeach; ?>
	</ul> <!--commentlist-->
</div><!-- comment -->