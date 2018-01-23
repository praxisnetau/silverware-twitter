# SilverWare Twitter Module

[![Latest Stable Version](https://poser.pugx.org/silverware/twitter/v/stable)](https://packagist.org/packages/silverware/twitter)
[![Latest Unstable Version](https://poser.pugx.org/silverware/twitter/v/unstable)](https://packagist.org/packages/silverware/twitter)
[![License](https://poser.pugx.org/silverware/twitter/license)](https://packagist.org/packages/silverware/twitter)

Provides a [Twitter Timeline Widget][twtimelinewidget] component, [Twitter Follow Button][twfollowbutton] component
and [sharing button][twsharebutton] for use with [SilverWare][silverware].

## Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Issues](#issues)
- [Contribution](#contribution)
- [Maintainers](#maintainers)
- [License](#license)

## Requirements

- [SilverWare][silverware]
- [SilverWare Social Module][silverware-social]

## Installation

Installation is via [Composer][composer]:

```
$ composer require silverware/twitter
```

## Usage

### Twitter Timeline Widget

![Twitter Timeline Widget](https://i.imgur.com/fsdZKy4.png)

This module provides a `TwitterTimelineWidget` component which can be added to a [SilverWare][silverware]
template or layout using the CMS. The widget shows the most recent tweets from a particular Twitter
user's timeline.

Add the component where desired in your template or layout, and enter the Twitter usename
in the "Username" field.  Additional settings are available on the Style and Options tabs.

For more information about the Twitter Timeline Widget, see the [Twitter documentation][twtimelinewidget].

### Twitter Follow Button

![Twitter Follow Button](https://i.imgur.com/ojdEIRc.png)

You may also add a `TwitterFollowButton` component to your SilverWare template or layout.
This component simply adds a button which allows users to follow a particular username on Twitter.

Add the component where desired in your template or layout, and enter the Twitter usename
in the "Username" field.  Additional settings are available on the Style and Options tabs.

For more information about the Twitter Follow Button, see the [Twitter documentation][twfollowbutton].

### Twitter Sharing Button

![Twitter Sharing Button](https://i.imgur.com/gc0cnAe.png)

Also provided is a `TwitterSharingButton` which is used with the `SharingComponent`
from the [SilverWare Social Module][silverware-social]. Simply add this button as a child of
`SharingComponent` using the site tree, and your pages will now
be able to be shared via Twitter.

For more information, see the [Twitter documentation][twsharebutton].

## Issues

Please use the [GitHub issue tracker][issues] for bug reports and feature requests.

## Contribution

Your contributions are gladly welcomed to help make this project better.
Please see [contributing](CONTRIBUTING.md) for more information.

## Maintainers

[![Colin Tucker](https://avatars3.githubusercontent.com/u/1853705?s=144)](https://github.com/colintucker) | [![Praxis Interactive](https://avatars2.githubusercontent.com/u/1782612?s=144)](https://www.praxis.net.au)
---|---
[Colin Tucker](https://github.com/colintucker) | [Praxis Interactive](https://www.praxis.net.au)

## License

[BSD-3-Clause](LICENSE.md) &copy; Praxis Interactive

[composer]: https://getcomposer.org
[twtimelinewidget]: https://dev.twitter.com/web/embedded-timelines
[twsharebutton]: https://dev.twitter.com/web/tweet-button
[twfollowbutton]: https://dev.twitter.com/web/follow-button
[silverware]: https://github.com/praxisnetau/silverware
[silverware-social]: https://github.com/praxisnetau/silverware-social
[issues]: https://github.com/praxisnetau/silverware-twitter/issues
