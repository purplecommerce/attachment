<?php
namespace PurpleCommerce\Attachment\Block;

use Exception;
use Psr\Log\LoggerInterface;
use Magento\Sales\Api\Data\InvoiceInterface;
use Magento\Sales\Api\InvoiceRepositoryInterface;
use \Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Authorization\Model\UserContextInterface;


class Index extends \Magento\Framework\View\Element\Template
{   
     /**
     * @var InvoiceRepositoryInterface
     */
    private $invoiceRepository;
    protected $orderRepository;
    protected $timezone;

    /**
     * @var LoggerInterface
     */
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_adminSession;
    
    private $logger;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        InvoiceRepositoryInterface $invoiceRepository,
        OrderRepositoryInterface $orderRepository,
        \Magento\Backend\Model\Auth\Session $adminSession,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        LoggerInterface $logger,
        array $data = []
        
    ) {
        parent::__construct($context, $data);
        $this->invoiceRepository = $invoiceRepository;
        $this->orderRepository = $orderRepository;
        $this->logger = $logger;
        $this->timezone = $timezone;
        $this->_adminSession = $adminSession;
    }
     /**
     * Get Invoice data
     *
     * @return InvoiceInterface|null
     */
    public function getInvoiceData($id): ?InvoiceInterface
    {
        $invoiceId = $id;
        try {
            $invoiceData = $this->invoiceRepository->get($invoiceId);
        } catch (Exception $exception)  {
            $this->logger->critical($exception->getMessage());
            $invoiceData = null;
            // echo "inside";
        }
        // echo "<pre>";
        // print_r($invoiceData->getData());
        // echo "</pre>";
        // die;
        return $invoiceData;
    } 
    
    public function getOrderData($id)
    {
        $order;
        $invoiceId = ltrim($id, '#');
        try {
            $invoiceData = $this->invoiceRepository->get($invoiceId);
            $order = $invoiceData->getOrder();
            // echo "in this";
            
        } catch (Exception $exception)  {
            $this->logger->critical($exception->getMessage());
            $invoiceData = null;
            $orderId = null;
            echo "inside";
        }
        // echo "<pre>";
        // print_r($invoiceData->getData());
        // echo "</pre>";
        // die;
        return $order;
    }
    
    public function getOrderRepo($oid)
    {
        
        try {
            $order = $this->orderRepository->get($oid);
            // $ordData = $orderRepo->getStoredData();
            // $orderIncrementId = $order->getIncrementId();
            
        } catch (Exception $exception)  {
            $this->logger->critical($exception->getMessage());
            $order = null;
            // echo "inside";
        }
        // echo "<pre>";
        // print_r($invoiceData->getData());
        // echo "</pre>";
        // die;
        return $order;
    }

    public function getAmountInWords($number){
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
            "and " . $words[$point / 10] . " " . 
                $words[$point = $point % 10] : '';
        if($points!==''){
            $points = $points ." paisa";
        }else{
            $points = '';
        }
        return "Rupees ".$result."".$points;
    }

    public function getCurrentUser(){
        $roleId = $this->_adminSession->isLoggedIn();
        return $roleId;
    }

    public function getConvertedDate($userDate){
        $dateTimeZone = $this->timezone->date(new \DateTime($userDate))->format('d/m/Y');
        return $dateTimeZone;
    }
    
}