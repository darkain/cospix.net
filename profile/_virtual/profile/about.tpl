<h3>About Me</h3>

<div itemprop="description">
	<p>
		[onshow;block=p;when [profile.id]!=[user.user_id]]
		[account.bio;safe=no]
	</p>
	<p title="Click to edit" class="af-edit-field">
		[onshow;block=p;when [profile.id]=[user.user_id]]
		[account.bio;safe=no]
	</p>
	<textarea class="edit-field af-edit-field">[account.user_bio;safe=nobr][onshow;block=textarea;when [profile.id]=[user.user_id]]</textarea>
</div>
