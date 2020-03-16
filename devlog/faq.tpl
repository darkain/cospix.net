<title>Devlog FAQ</title>

<main class="cpn-default">
	<h1 class="cpn-header">[af.title]</h1>
	<div class="cpn-default largest">

		<p>
			This page is for notes from Vince - The founder and lead software
			engineer / software architect for the Cospix.net Website.
		</p>

		<p>
			I'm putting these notes together because while streaming online
			via LiveCoding.tv, several very common repeat questions keep popping
			up. I sometimes stream my programming sessions while working on the
			Cospix.net Website. If you would like to watch, simply check out my
			profile:
		</p>

		<p>
			<a href="https://www.livecoding.tv/darkain/" target="_blank">
				https://www.livecoding.tv/darkain/
			</a>
		</p>

		<p>
			<b>Q: What language(s) are you programming in?</b><br/>
			<i>A: PHP, Hack, SQL, HTML5, JavaScript, CSS3, TBX</i>
		</p>

		<p>
			<b>Q: Are you using a framework?</b><br/>
			<i>A: YES! Our team uses the AltaForm framework. This includes several
			libraries that we've developed. PUDL (The PHP Universal Database Library)
			is used to handle all of our SQL connectivity and query generation.
			GetVar is used for all of our form and data input. We also use
			TinyButXtreme (TBX) as our HTML templating system, this is a fork of
			TinyButStrog (TBS) with many additional features and bug fixes but also
			stripping out large sections of code not used by our team.
			You can find all of this at my personal GitHub:
			<a href="https://github.com/darkain?tab=repositories" target="_blank">
				https://github.com/darkain?tab=repositories
			</a> (note: as of this writing, the framework is still undocumented. there
			are currently no written instructions on how to get started, as it was
			intended to be an internal tool mostly. this will change in the future)</i>
		</p>

		<p>
			<b>Q: What operating system(s) are you using?</b><br/>
			<i>A: My desktop and laptop (the machines I code on) are both running
			Windows 7. The servers are a very mixed environment. We currently have
			VM-Ware ESXi, SmartOS, and OpenVZ hypervisors in production. Our server
			client OSes are a mix of SmartOS zones, SmartOS LX Branded Zones,
			TurnKey Linux, Ubuntu Linux, Debian Linux, FreeNAS, and pfSense.</i>
		</p>

		<p>
			<b>Q: What server software are you running?</b><br/>
			<i>A: Again, a huge mix! We have PHP 5.6 and HHVM 3.9 in production
			as of this writing, and PHP 7 in testing. We user both MariaDB 10
			(standard) and MariaDB Galera Cluster 10, each both in development
			and production. We have Redis as our memory caching system. And
			lastly we use both Nginx and Apache as our front-facing web servers.</i>
		</p>

		<p>
			<b>Q: Why don't you use [INSERT-NAME-HERE] framework?</b><br/>
			<i>A: Our team has evaluated countless frameworks over the years and
			found that none of them could meet enough of our needs. Most were too
			slow. This alone would kill it for us. After performance came ease of
			implementing extremely short and simple scripts. If it took 10 lines
			of setup code just to write "hello world", then the framework wasn't
			simplistic enough for us. The last test is extreme complexity. In
			some instances, we're pushing SQL query strings that contain 20+ table
			join. Not everyone would say this is a "good" thing, but we have a
			reason for needing this. Managing complex SQL queries while
			programmatically specifying which tables to include and how is one
			of our most power features.</i>
		</p>

		<p>
			<b>Q: Are you a cosplayer?</b><br/>
			<i>A: NOPE! I'm a prominent photographer in the North American
			cosplay community though. The Cospix.net Website was initially
			built as a way for me to host my own vast amounts of cosplay
			photographs from over 10 years of photography. </i>
		</p>
	</div>
</main>
