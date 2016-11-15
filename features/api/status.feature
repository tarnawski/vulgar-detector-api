Feature: Status
  In order to have possibility to check API status
  As a user
  I need to be able ping api

  Background:
    Given There are the following words:
      | NAME   | LANGUAGE |
      | test   |    PL    |
      | fuck   |    EN    |

  @cleanDB
  Scenario: Ping api
    When I send a GET request to "/status"
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "words": "2",
      "languages": "2",
      "requests": 0,
      "requests_today": 0
    }
    """