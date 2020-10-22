<?php

/**
 * Class JpGraphExceptionL
 */
class JpGraphExceptionL extends JpGraphException
{
    /**
     * JpGraphExceptionL constructor.
     * @param $errcode
     * @param null $a1
     * @param null $a2
     * @param null $a3
     * @param null $a4
     * @param null $a5
     * @throws Exception
     */
    public function __construct($errcode, $a1 = null, $a2 = null, $a3 = null, $a4 = null, $a5 = null)
    {
        // make sure everything is assigned properly
        $errtxt = new ErrMsgText();
        JpGraphError::SetTitle('JpGraph Error: ' . $errcode);
        parent::__construct($errtxt->Get($errcode, $a1, $a2, $a3, $a4, $a5), 0);
    }
}