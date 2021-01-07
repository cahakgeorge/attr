# User Story

**As a** Marketing Executive at MegaLand\
**I want to** capture Visitor details\
**So that** I can wow our customers with amazing deals/offers/news about our Resort.

**Context:** This imaginary story would be part of a wider epic. The team has decided that it's valuable to split out a wider User Registration piece
into smaller components in line with [INVEST](https://www.agilealliance.org/glossary/invest/).



The acronym INVEST helps to remember a widely accepted set of criteria, or checklist, to assess the quality of a user story. If the story fails to meet one of these criteria, the team may want to reword it, or even consider a rewrite (which often translates into physically tearing up the old story card and writing a new one).

A good user story should be:

“I” ndependent (of all others)
“N” egotiable (not a specific contract for features)
“V” aluable (or vertical)
“E” stimable (to a good approximation)
“S” mall (so as to fit within an iteration)
“T” estable (in principle, even if there isn’t a test for it yet)
Origins
2003: the INVEST checklist for quickly evaluating user stories originates in an article by Bill Wake, which also repurposed the acronym SMART (Specific, Measurable, Achievable, Relevant, Time-boxed) for tasks resulting from the technical decomposition of user stories.
2004: the INVEST acronym is among the techniques recommended in Mike Cohn’s “User Stories applied“, which discusses it at length in Chapter 2.


# Acceptance criteria

A Registered User [domain entity](https://enterprisecraftsmanship.com/2016/01/11/entity-vs-value-object-the-ultimate-list-of-differences/) is created with the following **required** properties:
    - First name (max 32 chars)
    - Last name (max 32 chars)
    - Date of birth (min age, 13 years old)
        - It should be possible to get the user's age in years as this'll be displayed in the App's UI.
    - Email address (max 254 chars)
    - Password (max 32 chars)

# Developer notes

- Namespace can be `AttractionsIo\Domain\*`
- Vanilla OOP PHP should be used.
- The entity model should utilise at least one [value object](https://enterprisecraftsmanship.com/2016/01/11/entity-vs-value-object-the-ultimate-list-of-differences/), of which date of birth should be one.
- Date of Birth and Email Address should be covered with Unit Tests.
- To keep the task short, do **not** persist to a data store, just interested in the Domain Entity itself.
- README included with any necessary setup instructions in order to run Unit Tests.
- **Optional Bonus:** Should be containerised via a Docker, using docker-compose to orchestrate the containers.


Use composer to install phpunit
`AttractionsIo\Domain\*`
Class User namespace, interface

    SignupUser:
        Input:
            - First name (max 32 chars)
            - Last name (max 32 chars)
            - Date of birth (min age, 13 years old)
                - It should be possible to get the user's age in years as this'll be displayed in the App's UI.
            - Email address (max 254 chars)
            - Password (max 32 chars)
    Validations:

Test Class