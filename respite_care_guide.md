# Respite Care: Booking System, UX & Funding Guide
**Continuity of Care Services – Maidstone, Kent**
*Compiled March 2026*

---

## Table of Contents
1. [Booking System Strategy](#booking-system)
2. [Website UX & Customer Journey](#ux-journey)
3. [Customer Journey Map Template](#journey-map)
4. [Booking Integration in the Journey](#booking-integration)
5. [Common Pain Points at Touchpoints](#pain-points)
6. [Mitigating Financial Barriers](#financial-barriers)
7. [Kent Funding: Step-by-Step Guides](#kent-funding)
8. [NHS Continuing Healthcare (CHC)](#chc)
9. [Direct Payments for Respite](#direct-payments)
10. [Carers Trust Kent Grants](#carers-trust)
11. [Complaints & Appeals](#complaints-appeals)

---

## 1. Booking System Strategy <a name="booking-system"></a>

**Recommended approach**: Public enquiry / "request to book" on the website, with actual booking and confirmation handled internally — not a live self-service calendar.

### Why Not a Full Self-Service Booking Calendar?

Respite stays need assessment, risk, and availability checks before safely confirming dates (care plan, funding type, meds, moving/handling). Many providers treat the first step as an enquiry rather than a hard booking. Health settings prefer an asynchronous/request model when clinical triage is needed.

### Recommended Website Journey

- **Clear CTA**: "Enquire about respite dates" rather than "Book now"
- **Short guided form**: Who needs care, preferred dates, funding route, mobility/needs flags, preferred contact method and time
- **Promise of response**: "We'll call you within 24 hours to confirm availability and next steps"
- **Availability guide** (optional): "Next available stays from mid-April" — updated manually to set expectations without live slot booking

### Internal Booking Workflow

1. **Triage call** – Phone converts vastly better than email/live chat for care bookings; make a quick outbound call your default first action
2. **Assessment & documentation** – Complete assessments, GP/meds info, funding confirmation, confirm exact dates
3. **Internal calendar** – Maintain "source of truth" in your care/rota system (not on the website) to avoid double-booking and align with staffing
4. **Confirmation pack** – Email/post confirmation, what to bring, fees, and a simple schedule for the stay

### When a Live Online Calendar Might Work

- Very low-risk, standardised "day respite" slots with minimal variation
- Pre-assessed returning clients where you already hold care plans and risk info
- Fixed "taster days" or group activities tied to respite (more like events)

> Even then, treat it as "reserve a slot, subject to final confirmation."

### Practical Implementation (for your WP site)

- Use an on-site respite enquiry form with conditional fields (funding, needs, dates) instead of a full booking engine
- Automate notifications so the care manager gets an immediate alert and checklist on submission
- If adding a calendar later, start with a "request a specific date" selector feeding your internal system — not exposing your full rota online

---

## 2. Website UX & Customer Journey <a name="ux-journey"></a>

### Core UX Principles

- **Typography & contrast**: Min 16px body text, WCAG AA+ contrast — suits older users, caregivers, and high mobile traffic (often 60%+ in care searches)
- **Trust signals everywhere**: CQC ratings, real client stories, carer bios, certifications — counter decision anxiety
- **Scannable pages**: Short paragraphs, bullet benefits, hero videos showing compassionate care in action

### Homepage Journey

| Element | Detail |
|---------|--------|
| Hero headline | "Respite care that gives families peace of mind" with calming senior/carer image |
| Quick paths | Sticky nav: "Respite Care", "Our Services", "About Us", "Enquire Now" |
| Social proof | 3–5 testimonials or "As seen in…" badges below the fold |

### Respite Service Page Flow

| Section | Content Focus | UX Element |
|---------|--------------|------------|
| Hero | "Flexible respite from 1 night to 6 weeks" + benefits icons | Prominent "Enquire about dates" CTA |
| Needs Match | Bullet scenarios: "Post-hospital recovery", "Carer holiday cover" | Accordion or tabs |
| Proof | Video testimonial + "Rated Excellent by CQC" | Embedded clip (under 60s) |
| Enquire Form | Name, email/phone pref, dates, needs summary, "Urgent?" checkbox | Progress bar, phone fallback CTA |

### Enquiry Form Best Practices

- Place above-fold on service pages; label as "Request a call about respite" not "Book now"
- Conditional logic: show/hide fields (e.g. funding type only if selected); pre-fill from URL if from ads
- Post-submit: Instant "Thanks – we'll call in 2 hours" page with calendar preview (non-bookable) and chat widget

### Site-Wide Enhancements

- **Mobile-first**: Test on real devices; ensure forms work with save-progress fallback
- **Speed/SEO**: Lazy-load images, critical CSS (as per your CCS theme); target "respite care Maidstone/Kent"
- **Exit intent**: Popup with "Need respite advice now? Chat or call" on bounce

---

## 3. Customer Journey Map Template <a name="journey-map"></a>

### Personas
- **"Exhausted Working Daughter"** – searches mobile, needs short-notice, emotionally overwhelmed
- **"Retired Spouse"** – phone prefers, funding-focused, needs reassurance

### Full Journey Map

| Stage | Caregiver Actions/Goals | Touchpoints | Emotions/Pain Points | Opportunities |
|-------|-------------------------|-------------|----------------------|--------------|
| **Awareness** | Notices need (burnout, hospital discharge) | Google "respite care near Maidstone", social ads | Overwhelmed, anxious | SEO homepage with empathy headline |
| **Consideration** | Researches providers, compares costs/funding | Service pages, testimonials, CQC ratings | Confused by jargon, trust concerns | Clear benefits, video stories, funding FAQ |
| **Enquiry** | Submits dates/needs or calls | Website form, phone/chat | Frustrated if no quick reply | Instant thanks + 24hr callback promise |
| **Assessment/Decision** | Provides details, visits/assessment | Phone triage, home visit | Relieved if empathetic, worried about fit | Streamlined checklist, carer matching |
| **Booking/Stay** | Confirms, prepares client | Contract/email, arrival | Hopeful, logistical stress | Prep pack PDF, what-to-bring checklist |
| **Post-Stay** | Reviews experience, potential repeat/referral | Feedback email/survey | Grateful or disappointed | NPS survey, testimonial request |

### Metrics to Track

- Enquiry drop-off rate: aim <20%
- Callback conversion: target 70%

### Tools

- **Free templates**: UXPressia, Custellence (drag-drop)
- **Your stack**: Notion/Google Sheets — fits existing build

---

## 4. Booking Integration in the Customer Journey <a name="booking-integration"></a>

Booking spans "Consideration" to "Decision" — the pivot from research to commitment.

| Journey Stage | Booking Role | Key Integration Steps | Emotions Addressed |
|---------------|--------------|-----------------------|--------------------|
| Consideration | Lead capture | Website form: dates, needs, urgency checkbox → auto-alert to team | Anxiety → Reassurance via "Reply in 24hrs" |
| Enquiry/Assessment | Triage & qualify | Phone callback, needs assessment, funding check → internal calendar check | Confusion → Clarity |
| Decision/Booking | Confirm & prep | Signed agreement, deposit, prep pack → CRM update and welcome email | Hesitation → Confidence |
| Stay | Fulfillment | Arrival handover, daily check-ins → feedback prompts | Stress → Relief |

### Integration Best Practices

- **Digital handoff**: Enquiry form feeds CRM (Notion or WP plugin) with auto-SMS/email: "We've checked availability – calling shortly"
- **Internal sync**: Link form data to rota tool (Google Calendar/Excel) — no public exposure
- **Feedback loop**: Post-enquiry NPS: "How easy was requesting respite?"
- **Edge cases**: "Emergency?" field triggers same-hour callback

> Boosts conversions 20–30% in care services via reduced friction while protecting compliance.

---

## 5. Common Pain Points at Booking Touchpoints <a name="pain-points"></a>

### Enquiry & Research Phase
- Limited visibility of real availability → "hunting around" for slots (max 1 month booking window vs 4)
- Overwhelming research: comparing providers, CQC ratings, funding eligibility without clear guidance
- Complex application processes for funded care feeling bureaucratic and time-consuming

### Assessment & Booking Phase
- Delays in response or assessments — caregivers waiting weeks amid urgent needs
- Trust issues: fears of poor care quality, abuse, disruption to client's routine/health
- Logistical mismatches: geographic access, transport, or slots not matching family schedules

### Confirmation & Prep Phase
- Short-notice hurdles: emergency needs unmet due to capacity or policy (e.g. 48hr cancellation rules)
- Incomplete info handoff: missing meds/care plans causing last-minute scrambles
- Cost opacity: unclear fees and funding gaps leaving families surprised

### Post-Booking & Stay Phase
- Adjustment anxiety: client distress from environment change, behavioural issues on return
- Reliability fails: late/early carers, cancellations, inconsistent quality
- Poor follow-up: no feedback loop, eroding loyalty for repeats

### Website Fixes
- Add availability teasers: "Upcoming short stays from April"
- Funding FAQ section addressing common cost questions
- "Urgent?" form field for priority callbacks
- Trust badges: CQC rating, client testimonials, carer DBS confirmation

---

## 6. Mitigating Financial Barriers <a name="financial-barriers"></a>

### Local Authority Funding (Kent)
- Request a free **Carers Assessment** and **Needs Assessment** from Kent County Council (KCC)
- Funded via direct payments, personal budgets, or arranged services — means-tested
- Eligible families may use **Attendance Allowance** or **Carer's Allowance** to top up contributions

### Grants and Charities
- **Carers Trust** (local Kent network): up to £400 per grant
- **Turn2us** search: matches grants by postcode/circumstances
- **Respite Association**, Ogilvie Charities, Age UK: no/low means test for many
- **NHS Continuing Healthcare (CHC)**: fully funds complex cases — check via GP or ICB

### Flexible Self-Funding Options
- Tiered packages: shorter stays (£100–£250/day), pay-as-you-go visits, community/volunteer hybrids
- Bundle with Attendance Allowance for self-payers
- Add a **"Funding Checker"** tool on your website linking to Turn2us

### Website Integration
On your respite page, add a "How to Fund This" section:
- Step-by-step KCC application guide
- Grant links (Carers Trust, Turn2us, Respite Association)
- Form field: "Funding type?" to personalize quotes

---

## 7. Kent Funding: Step-by-Step Guides <a name="kent-funding"></a>

### Requesting a Carers Needs Assessment (Kent)

> No permission needed from the care recipient.

1. Use KCC online self-referral form (reviewed in 2 working days) **OR** call **03000 41 61 61** (Mon–Fri 9am–5pm)
2. Assessor contacts within 6 weeks (urgent cases faster) for interview on wellbeing impact
3. Receive support plan with funding if eligible
4. Available if caring for adult 18+; combined with caree's assessment optional

**Kent Connect to Support**: [kent.connecttosupport.org](https://kent.connecttosupport.org)

### Local Council Funding Assessment (Step-by-Step)

1. **Request Care Needs Assessment** – free, via KCC Adult Social Care: **03000 41 81 81** or online form
2. **Financial Assessment** – means-tested on savings/income/property (disability costs disregarded)
3. **Receive care plan** – with funding allocation (direct payments, arranged service, or mix)
4. **Agree plan** and start respite; no charge if below threshold; reassess annually

**KCC Paying for Care**: [kent.gov.uk/social-care-and-health/adult-social-care/paying-for-care-and-support](https://www.kent.gov.uk/social-care-and-health/adult-social-care/paying-for-care-and-support)

### Kent Carers Support Plan: What to Expect

**Plan structure** includes:
- Outcomes (health, caring tasks, work/leisure)
- Actions (e.g. 10hrs/wk respite PA, emergency carer card, training workshops)
- Funding allocation (e.g. direct payments £20/wk)
- Review date

**Example**: "Goal: Reduce burnout – Support: 4x counselling, Something for Me grant, 20hrs/wk PA"

Integrated into CNA process; co-produced and reviewable when needs change.

### Average Timelines

| Stage | Timeline |
|-------|----------|
| CNA reviewed | 2 working days |
| Full assessment / contact | Up to 6 weeks (legal max) |
| Financial assessment | Weeks following CNA |
| KCC complaints response | 20 working days |
| LGO Ombudsman decision | Up to 12 months |
| Funding decisions nationally | 4–8 weeks post-assessment |

> Backlogs noted in Kent (2025 delays documented by ombudsman).

### Affordable Volunteer-Based Programs (UK)

| Programme | What They Offer | Cost |
|-----------|----------------|------|
| **Shared Lives** | Approved carers host 1–12 weeks | £200–£500/wk subsidised |
| **Crossroads Care / Kent** | Free/low-cost sitting/escort | Free–low fee |
| **Respite Association** | Grants + volunteer host links | ~£450 avg grant |
| **Age UK Kent** | Volunteer befriending / short breaks | Free |
| **KCC Short Breaks** | Contact 03000 41 81 81 | Funded/subsidised |

Search **Turn2us** or **carers.org** for local matches — ideal for low-needs trial breaks.

---

## 8. NHS Continuing Healthcare (CHC) <a name="chc"></a>

### What It Is
Fully funded (non-means-tested) NHS package for adults with a **primary health need** — arranged by Integrated Care Board (ICB). Kent via **Kent & Medway ICB**.

### CHC Assessment Process

**Stage 1 — Checklist Screening**
- Completed by GP/clinician; quick tool
- Positive result → triggers full assessment
- Fast-track available (under 48hrs) for unstable/terminal cases

**Stage 2 — Full MDT Assessment (DST)**
- Multi-disciplinary team scores 12 domains (behaviour, cognition, skin, mobility, etc.)
- ICB coordinates within **28 calendar days** of receiving positive checklist
- Written outcome letter provided with copy of DST

**After Positive Full Assessment**
- ICB arranges funding plan (home or residential respite)
- Review at 3/6/12 months

### If CHC Assessment Exceeds 28 Days

- NHS must **refund care costs from day 29** until decision if delay unjustified
- Chase ICB: **chc@kmicb.nhs.uk**
- Escalate to PALS/formal complaint if no action
- Cite National Framework in correspondence

### Common Reasons for CHC Full Assessment Rejection

- Needs scored as "social care dominant" (low clinical domain scores)
- Pre-judgment by assessors ("won't qualify")
- Cost-based excuses from ICB
- Condition deemed stable (not primarily health-driven)
- No multi-disciplinary assessor present

> Challenge via ICB review or Parliamentary & Health Service Ombudsman (PHSO).

---

## 9. Direct Payments for Respite <a name="direct-payments"></a>

### Eligibility Criteria

- Aged 16+ with eligible care needs (Care Act); carers or parents of disabled children
- Post-needs assessment with council approval
- Must have capacity to manage funds (or a nominated person)
- No disqualifiers: recent criminal offences, drug/alcohol orders, compulsory treatment orders
- Must sign monitoring agreement
- Means-tested amount; savings threshold applies (e.g. £23k disregard in some areas)

### Typical Amounts in Kent

| Type | Rate |
|------|------|
| Employed PA (hourly) | £12–£18/hr + ~20% on-costs (tax/NI) |
| Self-employed PA (hourly) | £22–£28/hr |
| Net weekly contribution | £20–£60/wk (after carer contribution) |
| Annualised for respite | £1,000–£5,000/yr |
| Care home respite cap | 4 weeks |

### Using Direct Payments to Hire PAs

1. **Post-assessment**: Receive cash equivalent of assessed need
2. **Recruit**: Via council PA support service or DBS-checked lists; draft employment contract
3. **Pay & report**: Invoice/pay PA; report quarterly spend to council
4. Kent allows use for informal carer breaks and holidays

**KCC Direct Payments**: [kent.gov.uk/social-care-and-health/adult-social-care/arranging-your-own-care/direct-payments](https://www.kent.gov.uk/social-care-and-health/adult-social-care/arranging-your-own-care/direct-payments)

---

## 10. Carers Trust Kent Grants <a name="carers-trust"></a>

### Availability by Area (Kent)

Delivered via local partners; varies by hub capacity and demand:

| Partner | Area | Contact |
|---------|------|---------|
| Care for the Carers (CFTC) | East Sussex / East Kent | 01323 738390 — cftc.org.uk |
| Carers' Support East Kent | East Kent | 01304 619919 — carersek.org.uk |
| Crossroads Care Kent East | East Kent | 01227 781150 |
| Crossroads Care West Kent | West Kent | 01622 814400 |
| Carers Trust Central | National | 0300 772 9600 — carers.org |

> Grants £100–£500 for respite; higher demand in urban Maidstone/Tonbridge. Availability quarterly — contact local hub for open windows.

### Application Process

1. **Get a Carers Needs Assessment** (within last 12 months)
2. **Contact local hub** (e.g. CFTC 01323 738390) to check open windows and prioritisation
3. **Download form**: [cftc.org.uk/resources-for-carers/grants-for-carers](https://www.cftc.org.uk/resources-for-carers/grants-for-carers/)
4. **Submit** with proof of expenditure (receipts/invoices) and ID
5. **Decision**: 6–8 weeks; up to **£400**

**Priority given to**: Carer's Allowance claimants; low-income carers without prior awards.

> No fixed county-wide deadline — rolling/quarterly windows. Always phone to confirm current availability.

---

## 11. Complaints & Appeals <a name="complaints-appeals"></a>

### Complaining About Delayed CHC Assessment

**2-stage NHS complaints process**:

1. **PALS / ICB First**
   - Contact Kent & Medway ICB: **chc@kmicb.nhs.uk**
   - Response within 25–40 working days
   - Demand backdated funding from day 29; cite National Framework

2. **Parliamentary & Health Service Ombudsman (PHSO)**
   - Free service; investigates maladministration/delays
   - Use after ICB complaint exhausted
   - [ombudsman.org.uk](https://www.ombudsman.org.uk)

### Appealing a Negative CHC Decision (3-Stage Process)

> Must be initiated within **6 months** of decision letter.

| Stage | Process | Timeline |
|-------|---------|----------|
| **1. Local Resolution** | ICB CHC manager review/meeting; submit evidence and DST critique | Weeks |
| **2. Independent Review Panel (IRP)** | NHS England panel re-scores DST; request via ICB | 3–6 months |
| **3. Judicial Review** | Court challenge for procedural flaws | Variable |

**Tips for appeal success**:
- Gather GP notes, care records, family testimonials
- Critique specific DST domain scoring errors
- Use free support from Beacon CHC or Scope
- Success rate ~30% at IRP

**Key contacts**:
- Scope CHC advice: [scope.org.uk/advice-and-support/appeal-an-nhs-continuing-healthcare-chc-decision](https://www.scope.org.uk/advice-and-support/appeal-an-nhs-continuing-healthcare-chc-decision)
- Beacon CHC: [beaconchc.co.uk](https://beaconchc.co.uk)

### Appealing KCC Funding Decisions

1. Complain to KCC → response within **20 working days**
2. Escalate to **Local Government Ombudsman (LGO)** → free, up to 12 months for decision
3. Backlogs noted in Kent 2025; document all delays with dates

---

## Quick Reference: Key Kent Contacts

| Organisation | Purpose | Contact |
|-------------|---------|---------|
| KCC Adult Social Care | CNA, direct payments, care plans | 03000 41 61 61 |
| KCC Care Needs Assessment | Respite funding | 03000 41 81 81 |
| Kent & Medway ICB | CHC assessments/complaints | chc@kmicb.nhs.uk |
| Care for the Carers (CFTC) | Carers Trust grants | 01323 738390 |
| Carers' Support East Kent | Grants, support | 01304 619919 |
| Crossroads Care East Kent | Volunteer respite | 01227 781150 |
| Crossroads Care West Kent | Volunteer respite | 01622 814400 |
| Carers Trust Central | National grants/network | 0300 772 9600 |
| PHSO | NHS complaints escalation | ombudsman.org.uk |
| Turn2us | Grant finder | turn2us.org.uk |

---

*Document compiled from multi-session research, March 2026. For Continuity of Care Services (continuitycareservices.co.uk), Maidstone, Kent.*
