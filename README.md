Caldera Forms Switch Processor
==============================

A Caldera Forms Processor to generate a magic tag value based on input
conditions. This plugin works with the Caldera forms plugin.


PREREQUISITES
=============

- PHP 7.0+
- Wordpress
- Caldera Forms 1.8+


INSTALLATION
============

Extract the plugin archive into your `wp-content/plugins` directory, and
activate via the Plugins Page in Wordpress.

USAGE
=====

1. Edit your Caldera Form,
2. Under the *Processors* tab, select *Add Processor*.
3. Use the *Switch: Case* processor.
4. Set the *Switch Label* to group your cases together.
   The *Switch Label* will determine what magic tag is used, so use lower case
   alphanumerics and underscores only, e.g. `my_value`.
5. Set the *Output* according to the value you need. Magic tags may be used.
6. Use the *Conditions* tab to determine when this case is evaluated according
   to your form elements and previous processors.
7. Repeat steps 2-6 for each case you require. Alternative cases for the same
   switch must use the same *Switch Label*
8. Select *Add Processor* and use the *Switch: Results* processor.
9. Processors placed after this in the order will now be able to use magic tags
   according to the *Switch Label*s configured in your cases, e.g. for the
   `my_value` label given previously, you would use `{switch:my_value}`

A default may be specified for any given *Switch Label* by creating a *Switch:
Case* processor for that label with no conditions. The value returned for a
given *Switch Label* will be that of its last evaluated Case, so as a general
rule you should provide the default first, and then additional cases in
increasing order of specificity.
