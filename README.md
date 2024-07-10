<!-- Improved compatibility of back to top link: See: https://github.com/osam7a/Etisalat-Payment-Wordpress/pull/73 -->
<a id="readme-top"></a>
<!--
*** Thanks for checking out the Best-README-Template. If you have a suggestion
*** that would make this better, please fork the repo and create a pull request
*** or simply open an issue with the tag "enhancement".
*** Don't forget to give the project a star!
*** Thanks again! Now go create something AMAZING! :D
-->



<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->
<div align="center">

[![Commits][commits-shield]][commits-url]
[![Issues][issues-shield]][issues-url]

</div>



<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/osam7a/Etisalat-Payment-Wordpress">
    <img src="logo.png" alt="Logo" height="80">
  </a>

  <h3 align="center">Etisalat Payment Gateway on Wordpress</h3>

  <p align="center">
    An open-source WordPress plugin for seamless integration with the Etisalat Payment Gateway in the UAE. 
    <br />
    <a href="https://github.com/osam7a/Etisalat-Payment-Wordpress/blob"><strong>See the change logs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/osam7a/Etisalat-Payment-Wordpress">View Demo</a>
    ·
    <a href="https://github.com/osam7a/Etisalat-Payment-Wordpress/issues/new?labels=bug&template=bug-report---.md">Report Bug</a>
    ·
    <a href="https://github.com/osam7a/Etisalat-Payment-Wordpress/issues/new?labels=enhancement&template=feature-request---.md">Request Feature</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

[![Product Name Screen Shot][product-screenshot]](https://github.com/osam7a/Etisalat-Payment-Wordpress)

This plugin provides a secure and efficient payment solution, allowing WordPress site owners to easily accept payments through the Etisalat network. It offers customizable settings, real-time transaction processing, and comprehensive documentation to facilitate smooth implementation. 

The Integration Plugin is an ideal solution for e-commerce businesses looking to expand their payment options in the UAE. By integrating with the Etisalat Payment Gateway, you can offer your customers a trusted and widely-used payment method. Improve your WordPress site’s functionality and provide a superior shopping experience with a reliable and efficient payment integration plugin.
<p align="right">(<a href="#readme-top">back to top</a>)</p>



### Built With

These are the most used frameworks & languages Etisalat-Payment-Wordpress is built with & developed on.

[![Wordpress][Wordpress]][Wordpress-url]
[![PHP][PHP]][PHP-url]
[![Woocommerce][Woocommerce]][Woocommerce-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- DEV QUICKSTART -->
## How to install?

The developer's quick start on installing & running Etisalat-Payment-Wordpress.

- Download the `etisalat-gateway.php` file
- Open your server's FTP and navigate to `wp-content/plugins/`
- Upload the `etisalat-gateway.php` file in that directory
- Go to your site's admin dashboard and navigate to `Plugins`
- Find "Etisalat Payment Gateway" and activate the Plugin
- Go to your Woocommerce Plugin settings
- Navigate to the "Payments" or "Checkout" tab
- Find "Etisalat Payment Gateway" and enable it, then click `Finish set up`
- If you want to use the sandbox version, incase you want to test the plugin - enable "Test Mode", set customer id to "Demo Merchant", and leave username and password blank
- Make a new page on Wordpress for failed payments, the user will be redirected there after a failed payment (Insufficient Funds, Do Not Honor, etc.)
- Set the "Payment Failed Page URL" with the url of the page you just created
- If you do not want to use the sandbox version, set the Username & Password with your gateway credentials, and set the Customer ID with the customer id you will find in the payment gateway settings


<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ROADMAP -->
## Roadmap

- [x] Basic functionalities of redirection from site to gateway and back.
- [ ] Better & More user-friendly error handling, especially in Payment Failed case.
- [ ] A more secure approach towards hiding the Username & Password from other admin users.
- [ ] Button widgets for instant checkout (Including Apple Pay & GPay).
- [ ] Automatic invoice creation in plugin with company branding and details.
- [ ] Possibly more customizable payment page by API, which includes branding and theme customizing.

See the [open issues](https://github.com/osam7a/Etisalat-Payment-Wordpress/issues) for a full list of proposed features (and known issues).

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- CONTACT -->
## Contact

Osama - osamaziadalhinawi@gmail.com

Project Link: [https://github.com/osam7a/Etisalat-Payment-Wordpress](https://github.com/osam7a/Etisalat-Payment-Wordpress)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

Use this space to list resources you find helpful and would like to give credit to. I've included a few of my favorites to kick things off!

* [Wordpress Support Server #1](https://discord.gg/DdWmSGac)
* [Wordpress Support Server #2](https://discord.gg/RtqtJg9X)
* [Woocommerce Payment Gateway API](https://developer.woocommerce.com/docs/woocommerce-payment-gateway-api/)
* [Img Shields](https://shields.io)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/osam7a/Etisalat-Payment-Wordpress.svg?style=for-the-badge
[contributors-url]: https://github.com/osam7a/Etisalat-Payment-Wordpress/graphs/contributors
[commits-shield]: https://img.shields.io/github/commit-activity/t/osam7a/Etisalat-Payment-Wordpress.svg?style=for-the-badge
[commits-url]: https://github.com/osam7a/Etisalat-Payment-Wordpress/commits/
[issues-shield]: https://img.shields.io/github/issues/osam7a/Etisalat-Payment-Wordpress.svg?style=for-the-badge
[issues-url]: https://github.com/osam7a/Etisalat-Payment-Wordpress/issues
[license-shield]: https://img.shields.io/github/license/osam7a/Etisalat-Payment-Wordpress.svg?style=for-the-badge
[license-url]: https://github.com/osam7a/Etisalat-Payment-Wordpress/blob/master/LICENSE
[product-screenshot]: screenshot.png
[Woocommerce]: https://img.shields.io/badge/-white?style=for-the-badge&logo=woocommerce&logoColor=103e2e&logoSize=auto
[Woocommerce-url]: https://woocommerce.com
[PHP]: https://img.shields.io/badge/PHP-white?style=for-the-badge&logo=php&logoColor=103e2e
[PHP-url]: https://php.net
[Wordpress]: https://img.shields.io/badge/Wordpress-white?style=for-the-badge&logo=Wordpress
[Wordpress-url]: https://wordpress.org