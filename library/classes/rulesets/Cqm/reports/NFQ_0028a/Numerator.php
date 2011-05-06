<?php
class NFQ_0028a_Numerator implements CqmFilterIF
{
    public function getTitle()
    {
        return "Numerator";
    }

    public function test( CqmPatient $patient, $dateBegin, $dateEnd )
    {
        // See if user has been a tobacco user before or simultaneosly to the encounter within two years (24 months)
        foreach ( $this->getApplicableEncounters() as $encType ) 
        {
            $dates = Helper::fetchEncounterDates( $encType, $patient, $dateBegin, $dateEnd );
            foreach ( $dates as $date ) 
            {
                $begin_24_months_before_time = strtotime( '-24 month' , strtotime ( $date ) );
                $begin_24_months_before = date( 'Y-m-d 00:00:00' , $begin_24_months_before_time );
                $tobaccoHistory = getHistoryData( $patient->id, "tobacco", $begin_24_months_before, $dateEnd );
                if ( isset( $tobaccoHistory['tobacco'] ) ) 
                {
                    // If this patient was a current tobacco smoker at the time of this encounter, 
                    // or if they didn't quit more than 2 years before the encounter
                    $tmp = explode( '|', $tobaccoHistory['tobacco'] );
                    $tobaccoStatus = $tmp[1];
                    if ( $tobaccoStatus == 'currenttobacco' ) {
                        return true;
                    } else if ( $tobaccoStatus == 'quittobacco' ) {
                        $quitDate = $tmp[2];
                        if ( stringtotime( $quitDate ) > $begin_24_months_before_time ) {
                            return true;
                        }     
                    }        
                }
            }
        }
        

        return false;
    }
    
    private function getApplicableEncounters() 
    {
        return array( 
            Encounter::ENC_OFF_VIS,
            Encounter::ENC_HEA_AND_BEH,
            Encounter::ENC_OCC_THER,
            Encounter::ENC_PSYCH_AND_PSYCH,
            Encounter::ENC_PRE_MED_SER_18_OLDER,
            Encounter::ENC_PRE_IND_COUNSEL,
            Encounter::ENC_PRE_MED_GROUP_COUNSEL,
            Encounter::ENC_PRE_MED_OTHER_SERV );
    }
}