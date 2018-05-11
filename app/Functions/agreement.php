<?php
function get_agreement_content($user_id='') {
  if($user_id == ''){
    $user_id = auth()->user()->id;
  }
  $user = App\User::find($user_id);
if($user->is_partner==0):
return '<p>Whereas Conduct Clinical Trials. ("CCT"), Newport Beach, CA  has identified a potential clinical research opportunity,  ("Study"), being conducted by a research sponsor or CRO ("Sponsor") and Whereas  ("Investigator") has expressed interest in reviewing the protocol, potentially conducting said Study, and was submitted for said Study by CCT on date the "Investigator" signed Confidential Agreement (CDA).  CCT and Investigator agree to the following:</p>
<ul>
<li>CCT will submit Investigators credentials to the Sponsor of the Study. </li>
<li>Sponsor will submit protocol to Investigator.  CCT makes no guarantee that Sponsor will use Investigator.</li>
<li>Investigator will make a final determination on proceeding with the Study.  If you do not accept the study, you owe nothing to CCT. </li>
<li>Investigator will make a final determination on proceeding with the Study.  If you do not accept the study, you owe nothing to CCT.</li>
<li>If Sponsor does use Investigator for the Study, Investigator agrees to pay CCT in Newport Beach, CA the amount of $5,700 ("Marketing Fee").</li>
<li>The full amount of the Marketing Fee shall be due and payable upon execution of the clinical trial agreement (CTA).</li>
<li>If the Study is cancelled for reasons other than Investigator&apos;s performance on Study and prior to Investigator earning any funds from Sponsor, CCT will refund the Marketing Fee within 30 days notice of same from Investigator.</li>
<li>Except for the condition described in Number 6 above, the Marketing Fee shall be considered earned by CCT and therefore nonrefundable regardless of Investigator&apos;s subsequent performance and compensation received from Sponsor of the Study.</li>
<li>No Marketing Fee is owed to CCT for extensions of the current study or any future studies sent directly to the Investigator by the sponsor or CRO.</li>
<li>This Agreement shall remain in full force and effect for as long as Sponsor takes to select Investigators for this Study.</li> 
  <!--<li>
    Additional services available (Please initial any additional services needed)
    <ol>
      <li>Source document creation $750 ______</li>
      <li><strong>Budget negotiations (guaranteed minimum $5,000 increase to total contract depending on where you’re at in the negotiation process) $750 ______</strong></li>
      <li>Initial regulatory document submission $800 ______ </li>
      <li>Contract review by one of the top experts in the industry $750 _______ </li>
      <li>Standard Operating procedures (SOP’s) – Customized for your site $1000 ______</li>
    </ol>
  </li>-->
</ul>


<p>Investigator agrees to hold harmless CCT from and against any and all losses, claims, damages, liabilities and costs (including costs of defense and attorney&apos;s fees) arising from Investigators performance of the Study.  Investigator also agrees to hold harmless CCT from and against any and all losses, claims, damages, liabilities and costs (including costs of defense and attorney’s fees) arising from any subsequent cancellation of the Study.</p>

<p>This Agreement constitutes the entire agreement between Investigator and CCT with regard to the subject matter hereof.  Any modification or amendment of any provision of this Agreement must be in writing and signed by Investigator and CCT.  If either party becomes involved in litigation arising from this Agreement or the performance of it, the court in such litigation or in a separate suit shall award reasonable costs and expenses of litigation, including attorney\'s fees, to the prevailing party or parties.</p>

<p>This Agreement shall inure to the benefit of Investigator and CCT and all successors and assigns.  This Agreement shall be construed in accordance with, and governed by, the laws of the State of California.  Any litigation to enforce the terms of this Agreement shall be brought in Orange County, CA  and subject the parties to the jurisdiction of the State of California regardless of the location of Investigator’s residence or office.</p>';

  elseif($user->is_partner==2):
  $agreement = '';
  $agreement_data = App\Agreement::where("user_id",$user_id)->first();
  if($agreement_data){
    $agreement = $agreement_data->content;
  }
  return $agreement;
  endif;
}