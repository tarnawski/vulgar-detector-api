Feature: Check text
  In order to have possibility to check text is vulgar
  As a user
  I need to be able to check text and get response in specific format

  Background:
    Given There are the following words:
      | NAME   | LANGUAGE |
      | test   |    PL    |
      | fuck   |    EN    |

  @cleanDB
  Scenario: Check text with vulgar text
    When I send a POST request to "/" with body:
    """
    {
      "text": "fuck"
    }
    """
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "STATUS": "VULGAR"
    }
    """

  @cleanDB
  Scenario: Check text with decent text
    When I send a POST request to "/" with body:
    """
    {
      "text": "Example decent"
    }
    """
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "STATUS": "DECENT"
    }
    """

  @cleanDB
  Scenario: Check text with vulgar text and specific language
    When I send a POST request to "/" with body:
    """
    {
      "text": "fuck",
      "language": "pl"
    }
    """
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "STATUS": "DECENT"
    }
    """