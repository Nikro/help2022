<?php

namespace Drupal\h22_core\Plugin\MapLink;

use Drupal\address\AddressInterface;
use Drupal\address_map_link\MapLinkBase;
use Drupal\Core\Locale\CountryManager;
use Drupal\Core\Url;

/**
 * Provides a Google Maps Directions link type.
 *
 * @MapLink(
 *   id = "google_h22",
 *   name = @Translation("H22 - Google Direction")
 * )
 */
class GoogleMapH22 extends MapLinkBase {

  /**
   * Gets the map link url from an address.
   *
   * @param \Drupal\address\AddressInterface $address
   *   The address.
   *
   * @return \Drupal\Core\Url
   *   The Url.
   */
  public function getAddressUrl(AddressInterface $address) {
    return Url::fromUri('https://google.com/maps', ['query' => ['daddr' => $this->addressString($address)]]);
  }

  /**
   * Builds a query for use in a url for a single address item.
   *
   * @param \Drupal\address\AddressInterface $address
   *   The address.
   *
   * @return string
   *   A query string.
   */
  protected function addressString(AddressInterface $address) {
    $addressParameters = [];

    if ($address->getAddressLine1()) {
      $addressParameters[] = $address->getAddressLine1();
    }

    if ($address->getAddressLine2()) {
      $addressParameters[] = $address->getAddressLine2();
    }

    if ($address->getLocality()) {
      $addressParameters[] = $address->getLocality();
    }

    if ($address->getAdministrativeArea()) {
      $addressParameters[] = $address->getAdministrativeArea();
    }

    if ($address->getDependentLocality()) {
      $addressParameters[] = $address->getDependentLocality();
    }

    if ($address->getPostalCode()) {
      $addressParameters[] = $address->getPostalCode();
    }

    $countries = CountryManager::getStandardList();
    $full_country_name =  $countries[$address->getCountryCode()]->__toString();
    if ($address->getCountryCode()) {
      $addressParameters[] = $full_country_name;
    }
    return implode(' ', $addressParameters);
  }
}
