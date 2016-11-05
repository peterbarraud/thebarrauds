<?php
$json = json_decode(file_get_contents('admin-ui/services/dataobjectserver/common/dbmetadata.json'), true);
$mysqli = new mysqli(trim($json['dbserver']),trim($json['dbuser']),trim($json['dbpwd']),trim($json['dbname']));

?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>index</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="styles/main.css">
  </head>
  <body>
    <!--[if lte IE 8]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- <div class="logo-band">
      <img src="images/ufesm-emblem.png" class=logo-image alt="" />
    </div> -->
    <!-- top band - START -->
    <div class="topband">
      <div>
        <img src="images/ufesm-emblem.png" alt="" />
      </div>
      <div>
        <div><img src=''></div>
        <div>
          <div>
            <div>United Front of Ex-Servicemen</div>
            <div>G/F 128-H-2, Mohammad Pur, New Delhi - 110 066</div>
          </div>
          <div>
            <img src='images/indian-army-emblem.ac7905a1.png'>
            <img src='images/indian-airforce-emblem.7763c97f.png'>
            <img src='images/indian-navy-emblem.a240fee9.png'>
          </div>
        </div>
        <div><img src=''></div>
      </div>
    </div>
    <!-- top band - END -->
    <!-- navbar - START -->
    <!--this container spans a width that is more than the navbar itself. in this case, 100% -->
    <div class="nav-bar-container">
      <!-- we will us this div to ensure the navbar spans a percentage of the page width -->
      <div>
        <div role="navigation"><!--nav bar - START -->
          <ul>
            <?php
            if ($result = $mysqli->query('select id,position,level,title,pagename,parentid from menuitem order by position;')) {
              $menutitles = array();
              while ($row = $result->fetch_assoc()) {
                if ($row['level'] == 0){
                  $menuitems = $menutitles[$row['id']];
                  if (is_null($menuitems)){
                    $menuitems = array();
                  }
                  array_push($menuitems,$row);
                  $menutitles[$row['id']] = $menuitems;
                }
                else {
                  $menuitems = $menutitles[$row['parentid']];
                  array_push($menuitems,$row);
                  $menutitles[$row['parentid']] = $menuitems;
                }
              }
              foreach ($menutitles as $titleid => $menuitems) {
                if (sizeof($menuitems) == 1){
                  $menuitem = $menuitems[0];
                  echo '<li class="active"><a href="'. $menuitem['pagename'] . '">' . $menuitem['title'] . '</a></li>';
                }
                else {
                  $menuitem = $menuitems[0];
                  echo '<li>';
                  echo '<a href="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $menuitem['title'] . ' <span></span></a>';
                  echo '<ul>';
                  for ($i=1;$i<sizeof($menuitems);$i++){
                    $menuitem = $menuitems[$i];
                    echo '<li><a href="'. $menuitem['pagename'] . '">' . $menuitem['title'] . '</a></li>';

                  }
                  echo '</ul>';
                  echo '</li>';
                }
              }
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <!--nav bar - END -->
    <!-- marquee - START -->
    <div class="container-marquee">
      <marquee>
        <?php
          if ($result = $mysqli->query('select title from tickeritem order by position')) {
            while ($row = $result->fetch_assoc()) {
              echo '<span>' . $row['title'] . '</span>';
            }
          }
        ?>
      </marquee>
    </div>
    <!-- marquee - END -->
    <!-- carousel - START -->
    <div class="container-carousel">
      <div id="carousel-example-generic" class="carousel slide center-carousel" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
          <li data-target="#carousel-example-generic" data-slide-to="3"></li>
        </ol> <div class="carousel-inner" role="listbox">
          <div class="item active"> <img src="images/title-img-01.668f1f4c.png" alt="...">
            <!-- <div class="carousel-caption">
                <h3>Speaking at the ...</h3>
                <p>Making the speakers...</p>
              </div> -->
          </div>
          <div class="item"> <img src="images/title-img-02.e24a34bb.png" alt="...">
            <!-- <div class="carousel-caption">
                <h3>Attendees at the ...</h3>
                <p>Making the listeners...</p>
              </div> -->
          </div>
          <div class="item"> <img src="images/title-img-03.6643fc17.png" alt="...">
            <!-- <div class="carousel-caption">
                <h3>Heading for slide 3...</h3>
                <p>Text for slide 3...</p>
              </div> -->
          </div>
          <div class="item"> <img src="images/title-img-04.beec2f82.png" alt="...">
            <!-- <div class="carousel-caption">
                <h3>Heading for slide 3...</h3>
                <p>Text for slide 3...</p>
              </div> -->
          </div>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    <!-- carousel - END -->
    <!--page content - START -->
    <div class="page-content">
      <div class="row">
        <div class="col-xs-4 index-col">
          <div>
            <div>UFESM stands for Unity of ESM community</div>
            <!-- <img class='big-index-img' src="images/gallery-image-01.150592e0.png" alt="" /> -->
            <div>
              <p style="text-align:center"><strong>Don&rsquo;t Score Political Points: UFESM Denounces Akrosh Rally</strong></p>

<p style="text-align:center">UFESM To Meet PM To Press For OROP Demand</p>

<p style="text-align:center">Press Release - 12 Dec 2015</p>

<p>The United Front of Ex-Servicemen (UFESM) urges all agitating ex-servicemen and veterans to unite in this hour of crisis and join hands to project a cohesive picture to the country and display a sense of maturity.</p>

<p>The proposed Akrosh Rally by a group of fragmented elements of ex-servicemen who have been agitating for the cause without going into the broad-based merits of the One Rank One Pension (OROP) cause is likely to do more harm to the cause than can be visulaised at this particular juncture.</p>

<p>The majority of the Ex-servicemen across the country feel that is better to wait and watch before the tables are out rather than to jump and make a wrong political move.<br />
It is widely felt that when the government has committed to the cause, the continuing agitation at Jantar Mantar and stiff posturing is uncalled for.</p>

<p>The dwindling support the OROP movement has been receiving from the press is also due to the unwarranted posturing by the agitating ex-servicemen.</p>

<p>It is pertinent to mention that the UFESM delegation met the Defence Minister (RM) on Nov 26 and Finance Minister on Nov 24 drawing positive response from both the Cabinet ministers.</p>

<p>The RM was categorical about the Central Government&#39;s commitment to OROP in letter and spirit. The RM pointed out that whatever financial objections and bureaucratic hurdles the government was facing, it was more than willing to overcome in the right earnest.&nbsp;</p>

<p>Regarding PMR, the RM said it was being address and so was the case of other objections. The RM stated that he would discuss the major issues with the Prime Minister upon completing his international travel commitments.</p>

<p>The RM mentioned that after the Prime Minister had publicly accepted in principle the demand of OROP, the agitation by the few handful of ex servicemen only vitiated the atmosphere and spoil the bonhomie that was created after the announcement.<br />
UFESM delegation would&nbsp; meet the PM soon in this regard and the RM assured of facilitating such interaction.</p>

<p>UFESM secretary general Col Dinesh Nain said, &quot;We should take what we are getting and wait. There is no point in organizing a political rally when we are so close to the target. I urge all ex-servicemen not to hold the proposed rally and adopt and dignified wait and watch approach.&quot;&nbsp;<br />
<br />
Going by the announcements made by the RM, Finance Minister and Prime Minister Narendra Modi on implementing One Rank One Pension, the United Front of Ex-Servicemen is not taking part in the Akroash rally.</p>

<p>UFESM is a nation-wide umbrella organisation of 148 ex-servicemen organisations and NGOs. It is conducting itself in a dignified manner and not trying to score brownie points.</p>

<p>UFESM stands for improving the economic conditions of the widows, jawans and JCOs. It is essential that military pension of jawans and JCOs be restored back to the pre-1973 status. Jawans should get 75 percent of the top scale while retiring as pension. JCOs should get 70 percent of top scale while retiring as pension and Officers case for NFUs for status to be taken up with the Supreme Court.</p>

<div><strong>Col Dinesh Nain</strong></div>

<div><strong>Secretary General</strong></div>

<div><strong>8347020007</strong></div>

<p style="text-align:right">For More details, kindly contact, Capt M K Tayal<br />
Media Advisor,&nbsp;United front of Ex Servicemen (9810929963)</p>

            </div>
            <div>
              <a class="" href="ufesm-stands-for-unity-of-esm-community.php" role="button">Read more <span></span></a>
            </div>
          </div>
          <div>
            <div>Join UFESM... Today</div>
            <!-- <img class='big-index-img' src="images/gallery-image-01.150592e0.png" alt="" /> -->
            <div>
              <p>Membership of UFESM is open to all Ex-servicemen defence services - Army, Navy &amp; Air Force, Widows of Ex-servicemen and also to individual Ex-servicemen.</p>

<p>Fee:</p>

<p>A small fee is charged so that we at UFESM are able to meet our expenses for day to day functioning.</p>

<ol>
	<li>Subscription from members.</li>
	<li>Donations/ Contributions from volunteer individuals/organisations duly approved by the Governing Body.</li>
	<li>Lawful and authorized profit from any venture.</li>
</ol>

<p style="margin-left:.5in">Subscriptions&nbsp;are as under:-&nbsp;</p>

<p style="margin-left:1.0in">a. Admission Fee &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;Rs 50/-</p>

<p style="margin-left:1.0in">b. Yearly Subscription Rs 240/-&nbsp;</p>

<p style="margin-left:1.0in">c. Life Membership &nbsp; &nbsp; &nbsp;Rs 11000/-&nbsp;</p>

<p>Termination of Membership:</p>

<p>The Governing Body of UFESM shall have the power to expel/ terminate a member or/ and member/ veteran organisation from the membership of the UFESM, on any of the following grounds:</p>

<ol>
	<li>If any member wants to resign, a written communication is mandatory .</li>
	<li>If found to be involved in any anti-activities, any member can be terminated from the UFESM.</li>
	<li>If judged by any court of law to be a criminal offender.</li>
	<li>If found guilty by means of anti propaganda of the Aims and Objectives of the IESM</li>
</ol>

<p><strong>Bank Details</strong></p>

<p>You can&nbsp;kindly deposit your subscription/contributions directly under intimation, as per details as under:-</p>

<p style="margin-left:1.0in">a.&nbsp;Name: United Front of Ex-Servicemen. (Regn No 716/15 dt 30/10/15).</p>

<p style="margin-left:1.0in">b.&nbsp;Bank: Central Bank of India, at GF 128-H-2, Mohdpur New Delhi-66. &nbsp;&nbsp;</p>

<p style="margin-left:1.0in">c. SB A/c No &nbsp; 3500821007.</p>

<p style="margin-left:1.0in">&nbsp; &nbsp; Nicr code: &nbsp; 110016023.&nbsp;</p>

<p style="margin-left:1.0in">&nbsp; &nbsp; IFSCode: &nbsp;&nbsp;&nbsp; CBIN0280301 &nbsp;&nbsp;</p>

<p style="margin-left:1.5in">Note: after N it is zero &amp; not O alphabet.</p>

<p>&nbsp;</p>

<p>Here is our statement of accounts for the Month of Nov 2015</p>

<table border="0" cellpadding="0" cellspacing="0" style="width:681px">
	<tbody>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td colspan="6" style="height:20px; width:487px">
			<p>STATEMENT OF ACCOUNT FOR THE MONTH OF NOVEMEBER 2015</p>
			</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>RECEIPT</p>
			</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">
			<p>PAYMENT</p>
			</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">
			<p>BAL</p>
			</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">
			<p>5.11.15</p>
			</td>
			<td style="height:20px; width:175px">
			<p>DONATIONS</p>
			</td>
			<td style="height:20px; width:52px">
			<p>R. NO.</p>
			</td>
			<td style="height:20px; width:52px">
			<p>AMT</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">
			<p>5.11.15</p>
			</td>
			<td style="height:20px; width:97px">
			<p>CONF HALL</p>
			</td>
			<td style="height:20px; width:64px">
			<p>4500</p>
			</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>SH ISHWAR SINGH</p>
			</td>
			<td style="height:20px; width:52px">
			<p>15</p>
			</td>
			<td style="height:20px; width:52px">
			<p>1000</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>SH DS SHEORAN</p>
			</td>
			<td style="height:20px; width:52px">
			<p>14</p>
			</td>
			<td style="height:20px; width:52px">
			<p>2100</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>SH LR HOODA</p>
			</td>
			<td style="height:20px; width:52px">
			<p>16</p>
			</td>
			<td style="height:20px; width:52px">
			<p>500</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>INDIA FAUZI SANTHA</p>
			</td>
			<td style="height:20px; width:52px">
			<p>17</p>
			</td>
			<td style="height:20px; width:52px">
			<p>1100</p>
			</td>
			<td style="height:20px; width:44px">
			<p>4700</p>
			</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">
			<p>200</p>
			</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">
			<p>29.11.15</p>
			</td>
			<td style="height:20px; width:175px">
			<p>CAPT MS RANA</p>
			</td>
			<td style="height:20px; width:52px">
			<p>1</p>
			</td>
			<td style="height:20px; width:52px">
			<p>1100</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">
			<p>29.11.15</p>
			</td>
			<td style="height:20px; width:97px">
			<p>TEA/SNACKS</p>
			</td>
			<td style="height:20px; width:64px">
			<p>1600</p>
			</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>CAPT MBS BHATTI</p>
			</td>
			<td style="height:20px; width:52px">
			<p>2</p>
			</td>
			<td style="height:20px; width:52px">
			<p>1100</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">
			<p>OPEN OF A/C</p>
			</td>
			<td style="height:20px; width:64px">
			<p>1000</p>
			</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>COL ARSU</p>
			</td>
			<td style="height:20px; width:52px">
			<p>3</p>
			</td>
			<td style="height:20px; width:52px">
			<p>1010</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">
			<p>PTG CHARGES</p>
			</td>
			<td style="height:20px; width:64px">
			<p>900</p>
			</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>IESL (TN)</p>
			</td>
			<td style="height:20px; width:52px">
			<p>4</p>
			</td>
			<td style="height:20px; width:52px">
			<p>600</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">
			<p>PTG CHARGES</p>
			</td>
			<td style="height:20px; width:64px">
			<p>1400</p>
			</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>KKN DISTT ESM ASSN</p>
			</td>
			<td style="height:20px; width:52px">
			<p>5</p>
			</td>
			<td style="height:20px; width:52px">
			<p>500</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">
			<p>STNY/PHOTO</p>
			</td>
			<td style="height:20px; width:64px">
			<p>340</p>
			</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>SH AK DHIGRA</p>
			</td>
			<td style="height:20px; width:52px">
			<p>6</p>
			</td>
			<td style="height:20px; width:52px">
			<p>1100</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>TN AREA ESM</p>
			</td>
			<td style="height:20px; width:52px">
			<p>7</p>
			</td>
			<td style="height:20px; width:52px">
			<p>400</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>COL AK BHARDWAJ</p>
			</td>
			<td style="height:20px; width:52px">
			<p>8</p>
			</td>
			<td style="height:20px; width:52px">
			<p>1100</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>RIS MAJ OM PRAKASH</p>
			</td>
			<td style="height:20px; width:52px">
			<p>9</p>
			</td>
			<td style="height:20px; width:52px">
			<p>100</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>SOLD PROBLEM ORG</p>
			</td>
			<td style="height:20px; width:52px">
			<p>10</p>
			</td>
			<td style="height:20px; width:52px">
			<p>500</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>PB UFESM</p>
			</td>
			<td style="height:20px; width:52px">
			<p>11</p>
			</td>
			<td style="height:20px; width:52px">
			<p>200</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>DHANI CHAND</p>
			</td>
			<td style="height:20px; width:52px">
			<p>12</p>
			</td>
			<td style="height:20px; width:52px">
			<p>500</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>SH SK SHARMA</p>
			</td>
			<td style="height:20px; width:52px">
			<p>13</p>
			</td>
			<td style="height:20px; width:52px">
			<p>100</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:52px">
			<p>12010</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">
			<p>10140</p>
			</td>
			<td style="height:20px; width:64px">
			<p>1670</p>
			</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">
			<p>TOTAL BAL</p>
			</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">
			<p>1870</p>
			</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">
			<p>1.12.15</p>
			</td>
			<td style="height:20px; width:175px">
			<p>SH AK DHIGRA</p>
			</td>
			<td style="height:20px; width:52px">
			<p>6</p>
			</td>
			<td style="height:20px; width:52px">
			<p>1100</p>
			</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td colspan="2" style="height:20px; width:227px">
			<p>CHEQUE DEP IN CBI CP</p>
			</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>CASH IN HAND</p>
			</td>
			<td style="height:20px; width:52px">
			<p>1870</p>
			</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:175px">
			<p>CASH AT BANK</p>
			</td>
			<td style="height:20px; width:52px">
			<p>2000</p>
			</td>
			<td style="height:20px; width:52px">&nbsp;</td>
			<td style="height:20px; width:44px">&nbsp;</td>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:97px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td colspan="7" rowspan="3" style="height:20px; width:551px">
			<p>COMPILED BY</p>

			<p>DHANI CHAND</p>

			<p>TREASURER</p>
			</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:20px; width:66px">&nbsp;</td>
			<td style="height:20px; width:64px">&nbsp;</td>
		</tr>
	</tbody>
</table>

<p>&nbsp;</p>

<h2>&nbsp;</h2>

<p><strong><u>Donations</u>: as you wish for the noble cause.</strong></p>

            </div>
            <div>
              <a class="" href="Joining-UFESM.php" role="button">Read more <span></span></a>
            </div>
          </div>
        </div>
        <div class="col-xs-4 index-col">
          <div>
            <div>Why One Rank One Pension</div>
            <!-- <img class='big-index-img' src="images/gallery-image-01.150592e0.png" alt="" /> -->
            <div>
              <div>What is OROP</div>

<p>One Rank, One Pension(OROP), or same pension, for same rank, for same length of service, irrespective of the date of retirement. &rdquo; It is the basis for determining the pension and benefits of Indian Armed Forces till 1973, when it was terminated by the Indian Ministry of Defence (MOD), in an &quot;ex-parte&quot; decision, during the tenure of the Indira Gandhi led Indian National Congress.</p>

<p>The termination of OROP, and drastic decrease in Armed Forces soldiers pension from 70 percent to 37 percent of last pay drawn, two years after 1971 Bangladesh war, caused disquiet in the Indian Armed Forces and, since 2008, has been cause of public appeals and protests and hunger strikes by Armed Forces Veterans, overwhelming majority of whom retire before they are forty years old.</p>

<p>Against the background of four decades of unsuccessful attempts by Armed Forces veterans for implementation of OROP, the UPA Government, in 2008, during the tenure ofManMohan Singh as Prime Minister, while disregarding OROP for the armed forces, granted OROP in perpetuity, at the apex pay grade(Rs 80,000), the highest pay grade in the government, and a pay grade at which majority of the officials of India&#39;s Central Civil Services, including police officers, retire. OROP-2008 decision was processed in the Department of Pensions and Pensioners&#39; Welfare (DOP&amp;PW), a department directly under the Prime Minister, and the Prime minister&#39;s Office, by Indian Administrative service (IAS) and Indian Foreign Service (IFS) officers, who, not surprisingly, favored themselves with 100 percent OROP coverage at apex scales. The decision was implemented not by a public notification, but a slyly worded internal memo, issued by Department of Pensions and Pensioners&#39; Welfare. &#39;OROP-2008&#39; has neither discussed nor scrutinized by the media, or the Ministry of Finance, and for this reason remained little known.</p>

<p>&#39;OROP-2008&#39; while appearing to be selective, provides apex grade pay pension coverage to thousands of retired civilian officers, and assures all officers from Indian Administrative Service, Indian Foreign Service officers, and majority of the IPS.</p>

<p>In contrast to near hundred percent OROP coverage to past and future retiree from the civil services, including majority of civilian officers in Ministry of Defence responsible for providing secretarial, logistic, and rear area services to the Armed Forces, only a fraction of one percent of the armed forces officers, as hedge against their opposition to the scheme were provided coverage under the &#39;OROP -2008&#39;.</p>

<p>Senior defence officers were, according to a senior civil servant, incorporated in the scheme, in order to buy their silence. What was radical about the OROP-2008, was not that it covered a tiny fraction of Armed Forces Officers, but that it excluded the senior most ranks of the Armed Forces , including Major Generals, Lt Generals, Rear Admirals, and Vice Admirals, and Air Marshals, the commanders of Divisions, Corps, Air bases, and fleets. Less than .13 percent officers in the army, air force and navy are promoted as Lt Generals, Vice Admirals, and Air marshals.</p>

<p>&#39;Apex OROP-2008&#39;, was accompanied by two other radical decisions in 2008: grant of &#39;non- functional financial up-gradation&#39; to all Civil services including Indian police Service, and creation of several hundred new posts of secretaries and Special Secretaries, at the apex grade pay level, so as to make almost all civilian and police officers eligible for Apex scale OROP pensions. In the Police alone over three dozen new apex grade pay level post were created.</p>

<p>&#39;Non- functional financial up-gradation&#39;(NFU) was not extended to Armed Forces. These radical decisions, which increased the pay-pension gap between defence and civilian officials, and sharply down graded highly selective Armed Forces pay grades and ranks across the board, most significantly, at the critical senior ranks of Colonel to Major General, and their equivalent in the Indian Navy and the Indian Air Force(IAF), were widely resented by the armed forces.</p>

<p>Growing unease in the armed Forces, and escalating protest by veterans, with implementation of OROP as focus, led to setting up of a ten member all party Parliamentary Panel, known as the Koshyari Committee after its Chairman, to examine the OROP issue.</p>

<p>The Koshyari Committee after considering the evidence, and hearing oral depositions for eight months, in December 2011, unanimously found merit in OROP and strongly recommended that, &quot;Government should implement OROP in the defence forces across the board at the earliest and further that for future, the pay, allowances, pension, family pension, etc in respect of the defence personnel should be determined by a separate commission&quot;</p>

<p>Despite the Koshyari Committee report, public commitments, including in the parliament, and visible disaffection amongst the armed force veterans, the UPA Government was slow to reach out to the veterans and implement OROP.</p>

<p>In May 2014, the UPA Government having lost the election was replaced by replaced by the BJP led NDA Government, which like the congress party, had on several occasions committed to implement OROP: it was an integral part of the election manifesto of the INC and the Bharatiya Janata Party (BJP). Sonia Gandhi and Prime Minister Narendra Modi at political rallies made repeated commitments to implement OROP, if elected.</p>

<p>Narendra Modi, the BJP prime Ministerial candidate, in order to win armed forces and veteran support, had made Armed Forces issues, including implementation of OROP, election rallying call. But once in office the BJP, despite many pledges, and promises to implement OROP, was slow to implement OROP, and raised doubt about its commitment to implement OROP as provided for in the accepted definition. The BJP ambivalence provoked nation wide protests by the veterans, starting 15 June 2015.</p>

<p>Finally, on 5 September 2015, the NDA Government following 83 days of very public protest, including hunger strike, and assault by Delhi Police on the protesting Veterans announced, unilaterally, the implementation the &#39;OROP Scheme&#39; for the Armed Forces.</p>

<p>The Government announcement was greeted with dismay, and appointment. The veteran organization denounced &#39;OROP-2015&#39; saying it was not OROP. It did not conform with the &#39;accepted&#39; definition of OROP, and decided to continue with their protest saying that the protest will continue till the Government complies with the accepted definition of OROP.</p>

            </div>
            <div>
              <a class="" href="Why-One-Rank-One-Pension.php" role="button">Read more <span></span></a>
            </div>
          </div>
          <div>
            <div>Revision of pension</div>
            <!-- <img class='big-index-img' src="images/gallery-image-01.150592e0.png" alt="" /> -->
            <div>
              <p style="text-align:center">Revision of pension in r/o pre&shy;2006 JCOs/ORs pensioners/Family pensioners</p>

<div style="text-align:center">OFFICE OF THE PR. CONTROLLER OF DEFENCE ACCOUNTS (PENSIONS)</div>

<div style="text-align:center">DRAUPADI GHAT, ALLAHABAD&shy; 211014</div>

<p>Circular No.549</p>

<p style="text-align:right">Dated: 30.09.2015</p>

<p><strong>Subject: &ndash; Revision of pension in r/o pre&shy;2006 JCOs/ORs pensioners/Family pensioners</strong></p>

<p>Reference: &shy;This office Circular No.547 dated 11.09.2015</p>

<p>PDAs are aware that as per this office Circular No. 547 dt. 11.09.2015, Service/Family pension in respect of JCOs/OR will be revised w.e.f 01.01.2006 by PDAs as per tables attached with above cited circular. It has come to the notice that various PDAs are feeling difficulties while revising the pension.</p>

<p>Clarifications on some of the major problems are as under:</p>

<ol>
	<li>
	<p>The Service Pension/Family pension has been revised w.e.f 1.1.2006 in r/o Pre&shy;06 pensioners vide this office Circular No. 547 dated 11th September 2015. The rates of Service/Family pension, if beneficial, shall be payable w.e.f 1.1.2006 to 30.06.2009 and thereafter, pension shall be revised according to this office Circular No. 430 dated 10.03.2010 except in cases of Hony. Lt and Hony. Capt. where it has been payable up to 23.09.2012 and thereafter pension shall be revised according to this office Circular No 501 dated 17.01.2013.</p>

	<p>It is hereby clarified that Service/Family pension of Pre&shy;06 JCOs/OR which has been revised under Sixth CPC,as per provisions contained in Para 4.1 of Ministry&rsquo;s letter No 17(4)/2008(1)/D(Pen/Pol) dated 11.11.2008 as amended therein, shall in no case be lower than fifty percent and thirty percent respectively, of the minimum of the pay in pay band plus the Grade pay corresponding to the pre&shy;revised scale from which the pensioner had retired /discharged/ invalided out/ died including Military Service Pay and &lsquo;X&rsquo; Group Pay, where applicable. Now, after issue of Circular under reference,&rdquo; minimum of the fitment table for the rank in the revised Pay Band&rdquo; has been taken into account instead of &ldquo;minimum of the pay in pay band&rdquo;. Exactly same treatment which was given to the Defence Civilians and Commissioned Officers vide this office Circular No. C&shy;144 dated 14.08.2015 and 548 dated 11.09.2015 respectively. Accordingly, Annexure III attached with GOI, MOD letter dated 11.11.2008,as amended from time to time may be replaced with tables attached with GOI,MOD letter dated 3rd September,2015 and shall be payable from 1.1.2006.</p>

	<p>Service Pension of JCOs/OR has been revised w.e.f 1.07.2009, on the basis of recommendations of CSC&shy;2009, @ 50% of the notional pay in the post 1.1.2006 revised pay structure corresponding to the maximum of pay scales applicable from 10.10.1997 for the rank and group continuously held for last 10 months preceding invalidment/discharge. The amount so determined shall be the pension for 33 years of reckonable qualifying service including rank weightage. This provision has been circulated vide this office CircularNo.430 dt.10.03.2010 showing the revised pension rates w.e.f 1.7.2009.</p>

	<p>Further, Service Pension/Family Pension of JCOs/OR has again been revised w.e.f 24.09.2012, on the basis of recommendation of CSC&shy;2012, @ 50% of notional maximum for the ranks and group across the three services. The, weightage has been enhanced by two years for Sepoy, Naik and Havildar rank. Pension of all pre&shy;1.1.2006 PBOR pensioners of Army, Navy and Air Force (including DSC and TA) shall be reckoned at 50% of the notional maximum for the rank and group across the three services. The above CSC&shy;2012 provisions have been circulated vide this office Circular No.501 dt. 17.01.2013 showing revised pension rates payable w.e.f 24.09.2012.</p>
	</li>
	<li>The Service/Family Pension rates for the rank of Hony. rank such as Hony. Naik, TS Naik, Hony Havidar and Hony Nb Sub have not been shown in this office Circular No. 547 dated 11.09.2015. In this context, it is hereby clarified that as per this office circular No 403 dated 02.02.2009,pension of TS Naik/Hony NK and Hony Havildar is Rs 1/&shy; less than pension admissible for NKs and Havildars for the same length of qualifying service and group of pay in which he was last paid respectively. It is therefore, clarified that the rate of pension shown in Annexure attached with GOI,MOD letter dated 3rd September 2015 (modified parity of pension) may be reduced by Rs 1/&shy; while comparing revised pension for TS Naik, Hony. Naik and Hony. Havildar. However, in case of Havildar granted Hony Nb&shy;Sub drawing pay in the scale of Havildar&rsquo;s rank i.e. rank held at the time of retirement, therefore, they are entitled for modified parity with reference to Havildar&rsquo;s rank i.e. the rank held by the individual at the time of retirement/discharged/invalidment.</li>
	<li>A pensioner who had retired with any rank and granted ACP&shy;I will be eligible for revision of pension of next higher rank, and if ACP&shy;II has been granted, he will be eligible for revision of pension of next higher rank of ACP&shy;I w.e.f. 01.01.2006 .</li>
	<li>Instructions have already been issued to PDAs vide this officecircular No 547 dated 11.09.2015 to revise the pension as per tables appended to Ministry of Defence letter dated 03.09.2015. Therefore, if the pension rates shown in &ldquo;sangam PPOs&rdquo; w.e.f. 01.01.2006 issued by this office are lower than this rate, the same may be stepped up to that level.</li>
	<li>Further, if the consolidated pension/family pension calculated as per Para 4.1 of Ministry&rsquo;s letter No. 17(4)/2008(1)/D(Pen/Pol) dated 11.11.2008 is higher than the pension/family pension shown in tables appended to Ministry of Defence letter dated 03.09.2015, the same(higher consolidated pension/family pension) will continued be treated as basic pension/family pension.</li>
	<li>However, where revised pension in terms of Govt of India, Ministry of Defence letter No. PC 10(1)/2009&shy;D (Pen/Pol) dated 08.03.2010 circulated vide this office Circular No.430 dated 10.03.2010 and GOI, MOD letter No. 1(13)/2012/D(Pen/Policy) dated 17.01.2013 circulated vide this office Circular No. 501 dated 17.01.2013 is higher than the rates indicated in annexure attached with circular under reference , the same will continued be treated as basic pension/family pension from 01.07.2009 and 24.09.2012 respectively.</li>
	<li>This circular has been uploaded on this office website www.pcdapension.nic.in for disseminating across the all concerned.</li>
</ol>

<p style="text-align:right">(G.K.Baranwal)</p>

<p style="text-align:right">Deputy Controller (Pensions)</p>

            </div>
            <div>
              <a class="" href="Revision-of-pension.php" role="button">Read more <span></span></a>
            </div>
          </div>
        </div>
        <!-- <div class="col-xs-4 index-col-last">
          <div>
            <div>Members' Corner</div>
            <div>
              <span></span><a href="[[members-corner-1-pagename]]">[[members-corner-1-pagename]]<span></span></a>
            </div>
            <div>
              <span></span><a href="[[members-corner-2-pagename]]">[[members-corner-2-pagename]]<span></span></a>
            </div>
            <div>
              <span></span><a href="[[members-corner-3-pagename]]">[[members-corner-3-pagename]]<span></span></a>
            </div>
          </div>
        </div> -->
    <!-- FOOTER nav bar - START -->
    <div class="footer-container">
      <div>  <!--col-4-->
        <div>United Front of Ex-Servicemen</div>
        <div>G/F 128-H-2</div>
        <div>Mohammad Pur</div>
        <div>New Delhi - 110 066</div>
      </div>
      <div>  <!--col-8-->
        <table>
          <tr>
            <?php
              $pagemenu = json_decode(file_get_contents('admin-ui/services/sitemenu.json'),true);
              foreach ($pagemenu as $menutitle) {
                echo "<td>";

                if (sizeof($menutitle['items']) > 0) {
                  echo $menutitle['title'];
                  foreach ($menutitle['items'] as $menuitem) {
                    echo '<div><a href="'. $menuitem['pagename'] . '">' . $menuitem['title'] . '</a></div>';
                  }
                }
                else {
                  echo '<a href="'. $menutitle['pagename'] . '">' . $menutitle['title'] . '</a>';
                }
                echo "</td>";
              }
            ?>
          </tr>
        </table>

      </div>
    </div>
    <!-- FOOTER nav bar - END -->







    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID -->
     <script>
       !function(A,n,g,u,l,a,r){A.GoogleAnalyticsObject=l,A[l]=A[l]||function(){
       (A[l].q=A[l].q||[]).push(arguments)},A[l].l=+new Date,a=n.createElement(g),
       r=n.getElementsByTagName(g)[0],a.src=u,r.parentNode.insertBefore(a,r)
       }(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

       ga('create', 'UA-XXXXX-X');
       ga('send', 'pageview');
    </script>

    <script src="scripts/vendor.223d857b.js"></script>


</body>
</html>
