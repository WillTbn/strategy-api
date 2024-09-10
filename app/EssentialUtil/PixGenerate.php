<?php

namespace App\EssentialUtil;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class PixGenerate
{
/**
   * IDs do Payload do Pix
   * @var string
   */
  const ID_PAYLOAD_FORMAT_INDICATOR = '00';
  const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
  const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
  const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
  const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
  const ID_MERCHANT_CATEGORY_CODE = '52';
  const ID_TRANSACTION_CURRENCY = '53';
  const ID_TRANSACTION_AMOUNT = '54';
  const ID_COUNTRY_CODE = '58';
  const ID_MERCHANT_NAME = '59';
  const ID_MERCHANT_CITY = '60';
  const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
  const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
  const ID_CRC16 = '63';
  const MSG_DESCRIPTION_INVESTMENT = 'Investindo na Strategy';
  const MSG_DESCRIPTION_WALLET = 'Adicionando saldo na carteira Strategy';

  /**
   * chave pix
   * @var string
   */
  private $pixKey;
  /**
   * Payment description
   * @var string
   */
  private $description;
  /**
   * Name of the account holder
   * @var string
   */
  private $merchantName;
  /**
   * Name of city the account holder
   * @var string
   */
  private $merchantCity;
  /**
   * Id transiction
   * @var string
   */
  private $txid;
  /**
   * Value transiction
   * @var string
   */
  private $amount;

  /**
   * Define the value $pixKey
   * @param string $pixKey
   */
  public function setPixKey($pixKey)
  {
    return $this->pixKey = $pixKey;
  }
  /**
   * Define the description
   * @param bool $investment
   */
  public function setDescription($investment)
  {
    return $this->description = $investment ? self::MSG_DESCRIPTION_INVESTMENT : self::MSG_DESCRIPTION_WALLET;
  }
  /**
   * Define the merchantName
   * @param string $merchantName
   */
  public function setMerchantName($merchantName)
  {
    return $this->merchantName = $merchantName;
  }
  /**
   * Define the merchantCity
   * @param string $merchantCity
   */
  public function setMerchantCity($merchantCity)
  {
    return $this->merchantCity = $merchantCity;
  }
  /**
   * Define the  txid
   * @param string $txid
   */
  public function setTxid($txid)
  {
    return $this->txid = $txid;
  }
  /**
   * Define the value  amount
   * @param float $amount
   */
  public function setAmount($amount)
  {
    return $this->amount = (string)number_format($amount, 2, '.','');
  }
  /**
   * Retorna valor completo de um objeto payload
   * @param string $id
   * @param string $value
   * @return string $id.$size.$value
  */
  public function getValue($id, $value)
  {
    $size = str_pad(strlen($value), 2,'0',STR_PAD_LEFT);
    return $id.$size.$value;
  }
   /**
   * Retorna os valores completo da informação da conta
   * @param string $id
   * @param string $value
   * @return string $id.$size.$value
  */
  private function getMechantAccountInformation()
  {
    //DOMINIO DO BANCO
    $gui = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI, 'br.gov.bcb.pix');
    //chave pix
    $key = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY, $this->pixKey);

    //Descrição do Pagamento
    $description = strlen($this->description) ? $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION, $this->description) :'';
    // VALOR COMPLETO DA CONTA
    return $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION,$gui.$key.$description);


  }
  /**
   * Retorna os valores completos do campo adicional do pix (TXID)
   * @return string
  */
  private function getAddicionalDataFieldTemplate()
  {
    $txid = $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID, $this->txid);
    return $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE, $txid);
  }
  /**
   * Método responsável por calcular o valor da hash de validação do código pix
   * @return string
   */
  private function getCRC16($payload) {
    //ADICIONA DADOS GERAIS NO PAYLOAD
    $payload .= self::ID_CRC16.'04';

    //DADOS DEFINIDOS PELO BACEN
    $polinomio = 0x1021;
    $resultado = 0xFFFF;

    //CHECKSUM
    if (($length = strlen($payload)) > 0) {
        for ($offset = 0; $offset < $length; $offset++) {
            $resultado ^= (ord($payload[$offset]) << 8);
            for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                if (($resultado <<= 1) & 0x10000) $resultado ^= $polinomio;
                $resultado &= 0xFFFF;
            }
        }
    }

    //RETORNA CÓDIGO CRC16 DE 4 CARACTERES
    return self::ID_CRC16.'04'.strtoupper(dechex($resultado));
}

  /**
   * Generate complete payoad code
   * @param float $amount
  */
  public function getPayload()
  {
    // create payload
    $payload = $this->getValue(self::ID_PAYLOAD_FORMAT_INDICATOR, '01', ).
    $this->getMechantAccountInformation().
    $this->getValue(self::ID_MERCHANT_CATEGORY_CODE, '0000').
    $this->getValue(self::ID_TRANSACTION_CURRENCY, '986').
    $this->getValue(self::ID_TRANSACTION_AMOUNT, $this->amount).
    $this->getValue(self::ID_COUNTRY_CODE, 'BR').
    $this->getValue(self::ID_MERCHANT_NAME, $this->merchantName).
    $this->getValue(self::ID_MERCHANT_CITY, $this->merchantCity).
    $this->getAddicionalDataFieldTemplate();
    // RETORNA PAYLOAD + CRC16
    return $payload.$this->getCRC16($payload);
  }

  /**
   * Image Qrcode
   * @param string $dataValue
   */
  public function generateQrCode(string $dataValue)
  {
    $qrCode = QrCode::size(120)->generate($dataValue);
    dd(base64_encode($qrCode->getValue()));
    return;
  }
}
